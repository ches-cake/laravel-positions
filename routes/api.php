<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PositionController;

Route::prefix('positions')->group(function () {
    Route::get('/', [PositionController::class, 'index']);
    Route::post('/', [PositionController::class, 'store']);
    Route::get('{id}', [PositionController::class, 'show']);
    Route::put('{id}', [PositionController::class, 'update']);
    Route::delete('{id}', [PositionController::class, 'destroy']);
});
