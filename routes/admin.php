<?php

use App\Http\Controllers\Admin\BloqueController;
use App\Http\Controllers\Admin\PaginaController;
use App\Http\Controllers\Admin\SeccionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('paginas', [PaginaController::class, 'index'])->name('paginas.index');
    Route::post('paginas', [PaginaController::class, 'store'])->name('paginas.store');
    Route::get('paginas/{pagina}', [PaginaController::class, 'show'])->name('paginas.show');
    Route::delete('paginas/{pagina}', [PaginaController::class, 'destroy'])->name('paginas.destroy');

    Route::post('paginas/{pagina}/secciones', [SeccionController::class, 'store'])->name('secciones.store');
    Route::put('secciones/{seccion}', [SeccionController::class, 'update'])->name('secciones.update');
    Route::delete('secciones/{seccion}', [SeccionController::class, 'destroy'])->name('secciones.destroy');
    Route::post('secciones/{seccion}/mover-arriba', [SeccionController::class, 'moveUp'])->name('secciones.mover-arriba');
    Route::post('secciones/{seccion}/mover-abajo', [SeccionController::class, 'moveDown'])->name('secciones.mover-abajo');

    Route::get('secciones/{seccion}/bloques/nuevo/{tipo?}', [BloqueController::class, 'create'])->name('bloques.create');
    Route::post('secciones/{seccion}/bloques', [BloqueController::class, 'store'])->name('bloques.store');
    Route::get('bloques/{bloque}/editar', [BloqueController::class, 'edit'])->name('bloques.edit');
    Route::put('bloques/{bloque}', [BloqueController::class, 'update'])->name('bloques.update');
    Route::delete('bloques/{bloque}', [BloqueController::class, 'destroy'])->name('bloques.destroy');
    Route::post('bloques/{bloque}/mover-arriba', [BloqueController::class, 'moveUp'])->name('bloques.mover-arriba');
    Route::post('bloques/{bloque}/mover-abajo', [BloqueController::class, 'moveDown'])->name('bloques.mover-abajo');
});
