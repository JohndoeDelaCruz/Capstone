<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

class CropPredictionService
{
    protected $apiUrl;
    protected $timeout = 30; // API timeout in seconds
    
    public function __construct()
    {
        // API URL from config or env
        $this->apiUrl = config('services.ml_api.url', 'http://127.0.0.1:5000');
    }
    
    /**
     * Check if the ML API is healthy
     */
    public function healthCheck()
    {
        try {
            $startTime = microtime(true);
            $response = Http::timeout(5)->get("{$this->apiUrl}/api/health");
            $responseTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
            
            Log::info('ML API Health Check', [
                'status' => $response->successful() ? 'success' : 'failed',
                'response_time_ms' => round($responseTime, 2)
            ]);
            
            return $response->successful() ? $response->json() : null;
        } catch (Exception $e) {
            Log::error('ML API Health Check Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
    
    /**
     * Get available options for the form (with caching)
     */
    public function getAvailableOptions()
    {
        return Cache::remember('ml_api_available_options', 3600, function () {
            try {
                $startTime = microtime(true);
                $response = Http::timeout($this->timeout)->get("{$this->apiUrl}/api/available-options");
                $responseTime = (microtime(true) - $startTime) * 1000;
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    Log::info('ML API Available Options Fetched', [
                        'response_time_ms' => round($responseTime, 2),
                        'cached' => false
                    ]);
                    
                    return $data;
                }
                
                throw new Exception('Failed to fetch available options: ' . $response->status());
            } catch (Exception $e) {
                Log::error('Failed to get available options', [
                    'error' => $e->getMessage(),
                    'url' => "{$this->apiUrl}/api/available-options"
                ]);
                throw $e;
            }
        });
    }
    
    /**
     * Make a single prediction
     * 
     * @param array $data
     * @return array
     */
    public function predict(array $data)
    {
        $requestData = [
            'MUNICIPALITY' => $data['municipality'],
            'FARM_TYPE' => $data['farm_type'],
            'YEAR' => $data['year'],
            'MONTH' => $data['month'],
            'CROP' => $data['crop'],
            'Area_planted_ha' => $data['area_planted'],
            'Area_harvested_ha' => $data['area_harvested'],
            'Productivity_mt_ha' => $data['productivity']
        ];
        
        try {
            $startTime = microtime(true);
            
            Log::info('ML API Prediction Request', [
                'input' => $requestData
            ]);
            
            $response = Http::timeout($this->timeout)->post("{$this->apiUrl}/api/predict", $requestData);
            
            $responseTime = (microtime(true) - $startTime) * 1000;
            
            if ($response->successful()) {
                $result = $response->json();
                
                Log::info('ML API Prediction Success', [
                    'response_time_ms' => round($responseTime, 2),
                    'prediction' => $result['prediction'] ?? 'N/A'
                ]);
                
                // Add response time to result
                $result['api_response_time_ms'] = round($responseTime);
                
                return $result;
            }
            
            $error = $response->json()['error'] ?? 'Unknown error occurred';
            
            Log::error('ML API Prediction Failed', [
                'status' => $response->status(),
                'error' => $error,
                'response_time_ms' => round($responseTime, 2)
            ]);
            
            throw new Exception($error);
            
        } catch (Exception $e) {
            Log::error('Prediction Exception', [
                'error' => $e->getMessage(),
                'input' => $requestData,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    /**
     * Make batch predictions
     * 
     * @param array $predictions
     * @return array
     */
    public function batchPredict(array $predictions)
    {
        try {
            $formattedData = array_map(function($item) {
                return [
                    'MUNICIPALITY' => $item['municipality'],
                    'FARM_TYPE' => $item['farm_type'],
                    'YEAR' => $item['year'],
                    'MONTH' => $item['month'],
                    'CROP' => $item['crop'],
                    'Area_planted_ha' => $item['area_planted'],
                    'Area_harvested_ha' => $item['area_harvested'],
                    'Productivity_mt_ha' => $item['productivity']
                ];
            }, $predictions);
            
            $response = Http::post("{$this->apiUrl}/api/batch-predict", [
                'predictions' => $formattedData
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            throw new Exception('Batch prediction failed');
            
        } catch (Exception $e) {
            Log::error('Batch prediction failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get model information and metadata
     */
    public function getModelInfo()
    {
        try {
            $response = Http::get("{$this->apiUrl}/api/model-info");
            
            if ($response->successful()) {
                return $response->json();
            }
            
            throw new Exception('Failed to fetch model info');
        } catch (Exception $e) {
            Log::error('Failed to get model info: ' . $e->getMessage());
            throw $e;
        }
    }
}