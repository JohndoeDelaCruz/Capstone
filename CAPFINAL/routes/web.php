<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CropPredictionController;
use App\Http\Controllers\CropDataController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Predictions routes (requires authentication)
    Route::prefix('predictions')->group(function () {
        Route::get('/', [CropPredictionController::class, 'index'])->name('predictions.index');
        Route::get('/predict', [CropPredictionController::class, 'index'])->name('predictions.predict.form');
        Route::post('/predict', [CropPredictionController::class, 'predict'])->name('predictions.predict');
        Route::post('/batch-predict', [CropPredictionController::class, 'batchPredict'])->name('predictions.batch');
        Route::get('/history', [CropPredictionController::class, 'history'])->name('predictions.history');
        Route::get('/options', [CropPredictionController::class, 'getOptions'])->name('predictions.options');
    });

    // Crop Data Management routes
    Route::prefix('crop-data')->name('crop-data.')->group(function () {
        Route::get('/', [CropDataController::class, 'index'])->name('index');
        Route::post('/import', [CropDataController::class, 'import'])->name('import');
        Route::post('/store', [CropDataController::class, 'store'])->name('store');
        Route::delete('/{id}', [CropDataController::class, 'destroy'])->name('destroy');
        Route::post('/delete-all', [CropDataController::class, 'deleteAll'])->name('delete-all');
        Route::get('/statistics', [CropDataController::class, 'getStatistics'])->name('statistics');
    });
});
require __DIR__.'/auth.php';
