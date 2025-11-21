<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AthleteController;

Route::prefix('v1')->group(function () {
    Route::apiResource('athletes', AthleteController::class);
});
