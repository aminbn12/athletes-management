<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AthleteController;

Route::get('/', function () {
    return redirect()->route('athletes.index');
});

Route::resource('athletes', AthleteController::class);

// Routes pour les autres sections
Route::prefix('evenements')->group(function () {
    Route::get('/', fn() => view('evenements.index'))->name('evenements.index');
});

Route::prefix('encadrants')->group(function () {
    Route::get('/', fn() => view('encadrants.index'))->name('encadrants.index');
});

Route::prefix('associations')->group(function () {
    Route::get('/', fn() => view('associations.index'))->name('associations.index');
});

Route::prefix('parametres')->group(function () {
    Route::get('/', fn() => view('parametres.index'))->name('parametres.index');
});