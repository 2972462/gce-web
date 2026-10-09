<?php

use App\Http\Controllers\DeployWebhookController;
use App\Http\Controllers\ProfileController;
use App\Models\PatenteComercialTramo;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tramos = PatenteComercialTramo::orderBy('orden')->get();

    // Enteros/float planos (no el modelo completo) para que el JSON
    // embebido no arrastre el problema de precision del "999999999999999".
    $tramosParaJs = $tramos->map(fn (PatenteComercialTramo $t) => [
        'desde' => (int) $t->monto_desde,
        'hasta' => (int) $t->monto_hasta,
        'porcentaje' => (float) $t->porcentaje,
        'adicional' => (int) $t->adicional,
    ]);

    return view('welcome', [
        'siteSetting' => SiteSetting::actual(),
        'tramos' => $tramos,
        'tramosParaJs' => $tramosParaJs,
    ]);
});

Route::post('/deploy-webhook', [DeployWebhookController::class, 'handle'])->name('deploy-webhook');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/public.php';
