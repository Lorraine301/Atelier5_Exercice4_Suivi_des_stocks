<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::middleware('api')->get('/test', function () {
    return response()->json(['message' => 'API fonctionne !']);
});

Route::apiResource('stocks', StockController::class);
Route::get('/stocks', [StockController::class, 'index']);
Route::post('/stocks', [StockController::class, 'store']);
Route::put('/stocks/{id}', [StockController::class, 'update']);
Route::delete('/stocks/{id}', [StockController::class, 'destroy']);
