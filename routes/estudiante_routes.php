<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;

Route::group(['prefix' => 'estudiantes', 'middleware' => 'auth_docentes'], function() {
    Route::get('/', [EstudianteController::class, 'index'])->name('estudiantes.index');
    Route::get('/show/{id}', [EstudianteController::class, 'show'])->name('estudiantes.show');
    Route::get('/create', [EstudianteController::class, 'create'])->name('estudiantes.create');
    Route::post('/store', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::get('/edit/{id}', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
    Route::put('/update/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::get('/delete/{id}', [EstudianteController::class, 'delete'])->name('estudiantes.delete');
    Route::delete('/destroy/{id}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');
});

Route::get('estudiantes/login', [EstudianteController::class, 'showLoginForm'])->name('estudiantes.showLoginForm');
Route::post('estudiantes/login', [EstudianteController::class, 'login'])->name('estudiantes.login');
Route::get('estudiantes/logout', [EstudianteController::class, 'logout'])->name('estudiantes.logout');
