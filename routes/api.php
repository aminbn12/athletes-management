<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AthleteController; // ✅ Contrôleur API
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/v1/athletes', [AthleteController::class, 'index']);
    Route::post('/v1/athletes/check-email', [AthleteController::class, 'checkEmail']);
    Route::get('/v1/athletes/{athlete}', [AthleteController::class, 'show']);
    Route::delete('/v1/athletes/{athlete}', [AthleteController::class, 'destroy']);
});
