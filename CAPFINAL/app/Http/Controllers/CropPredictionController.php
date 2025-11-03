<?php

namespace App\Http\Controllers;

use App\Services\CropPredictionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CropPredictionController extends Controller
{
    protected $predictionService;
    
    public function __construct(CropPredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }
    
    /**
     * Show the prediction form
     */
    public function index()
    {
        try {
            $options = $this->predictionService->getAvailableOptions();
            return view('farmers.predictions.index', compact('options'));
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to load prediction form: ' . $e->getMessage());
        }
    }
    
    /**
     * Make a prediction
     */
    public function predict(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'municipality' => 'required|string',
            'farm_type' => 'required|string',
            'year' => 'required|integer|min:2020|max:2030',
            'month' => 'required|integer|min:1|max:12',
            'crop' => 'required|string',
            'area_planted' => 'required|numeric|min:0',
            'area_harvested' => 'required|numeric|min:0',
            'productivity' => 'required|numeric|min:0'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            // Make prediction via ML API
            $result = $this->predictionService->predict($request->all());
            
            // Extract prediction data
            $prediction = $result['prediction'] ?? $result;
            
            // Save prediction to database
            $predictionRecord = \App\Models\Prediction::create([
                'user_id' => auth()->id(),
                'municipality' => $request->municipality,
                'farm_type' => $request->farm_type,
                'year' => $request->year,
                'month' => $request->month,
                'crop' => $request->crop,
                'area_planted_ha' => $request->area_planted,
                'area_harvested_ha' => $request->area_harvested,
                'productivity_mt_ha' => $request->productivity,
                'predicted_production_mt' => $prediction['production_mt'] ?? $prediction['Production_mt'] ?? 0,
                'expected_from_productivity' => $prediction['expected_from_productivity'] ?? $prediction['Expected_from_Productivity'] ?? 0,
                'difference' => $prediction['difference'] ?? $prediction['Difference'] ?? 0,
                'confidence_score' => $prediction['confidence_score'] ?? $prediction['Confidence_Score'] ?? 0,
                'api_response_time_ms' => $result['api_response_time_ms'] ?? null,
                'status' => 'success'
            ]);
            
            // Add prediction ID to result
            $result['prediction_id'] = $predictionRecord->id;
            
            return response()->json($result);
        } catch (\Exception $e) {
            // Save failed prediction to database
            try {
                \App\Models\Prediction::create([
                    'user_id' => auth()->id(),
                    'municipality' => $request->municipality,
                    'farm_type' => $request->farm_type,
                    'year' => $request->year,
                    'month' => $request->month,
                    'crop' => $request->crop,
                    'area_planted_ha' => $request->area_planted,
                    'area_harvested_ha' => $request->area_harvested,
                    'productivity_mt_ha' => $request->productivity,
                    'predicted_production_mt' => 0,
                    'expected_from_productivity' => 0,
                    'difference' => 0,
                    'confidence_score' => 0,
                    'status' => 'failed',
                    'error_message' => $e->getMessage()
                ]);
            } catch (\Exception $dbError) {
                \Log::error('Failed to save prediction error to database', [
                    'error' => $dbError->getMessage()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available options for AJAX
     */
    public function getOptions()
    {
        try {
            $options = $this->predictionService->getAvailableOptions();
            return response()->json($options);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show prediction history for the authenticated user
     */
    public function history(Request $request)
    {
        $query = \App\Models\Prediction::forUser(auth()->id())
            ->latest();

        // Apply filters
        if ($request->filled('crop')) {
            $query->byCrop($request->crop);
        }

        if ($request->filled('municipality')) {
            $query->byMunicipality($request->municipality);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $predictions = $query->paginate(20);

        // Get unique values for filters
        $crops = \App\Models\Prediction::forUser(auth()->id())
            ->select('crop')
            ->distinct()
            ->pluck('crop');

        $municipalities = \App\Models\Prediction::forUser(auth()->id())
            ->select('municipality')
            ->distinct()
            ->pluck('municipality');

        return view('farmers.predictions.history', compact('predictions', 'crops', 'municipalities'));
    }

    /**
     * Process batch predictions via queue
     */
    public function batchPredict(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'predictions' => 'required|array|min:1|max:100',
            'predictions.*.municipality' => 'required|string',
            'predictions.*.farm_type' => 'required|string',
            'predictions.*.year' => 'required|integer|min:2020|max:2030',
            'predictions.*.month' => 'required|integer|min:1|max:12',
            'predictions.*.crop' => 'required|string',
            'predictions.*.area_planted' => 'required|numeric|min:0',
            'predictions.*.area_harvested' => 'required|numeric|min:0',
            'predictions.*.productivity' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Dispatch batch prediction job
        \App\Jobs\ProcessBatchPrediction::dispatch(auth()->id(), $request->predictions);

        return response()->json([
            'success' => true,
            'message' => 'Batch prediction job queued successfully. You will see results in your prediction history.'
        ]);
    }
}