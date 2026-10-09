<?php

use App\Http\Controllers\Public\PatenteController;
use App\Http\Controllers\Public\RucController;
use Illuminate\Support\Facades\Route;

Route::prefix('consultas')->name('publico.')->group(function () {
    Route::get('ruc', [RucController::class, 'index'])->name('ruc.index');
    Route::post('ruc', [RucController::class, 'buscar'])->name('ruc.buscar')->middleware('throttle:10,1');

    Route::get('patente', [PatenteController::class, 'index'])->name('patente.index');
    Route::post('patente', [PatenteController::class, 'calcular'])->name('patente.calcular')->middleware('throttle:10,1');
});
