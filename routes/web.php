<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\HospedajeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hospedajes
    Route::resource('hospedajes', HospedajeController::class);

    // Habitaciones anidadas a hospedaje
    Route::resource('hospedajes.habitaciones', HabitacionController::class);

    // Reservas
    Route::resource('reservas', ReservaController::class);

    // Comentarios
    Route::post('hospedajes/{hospedaje}/comentarios', [ComentarioController::class, 'store'])
        ->name('hospedajes.comentarios.store');
    Route::delete('hospedajes/{hospedaje}/comentarios/{comentario}', [ComentarioController::class, 'destroy'])
        ->name('hospedajes.comentarios.destroy');

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
    });
});

require __DIR__.'/auth.php';