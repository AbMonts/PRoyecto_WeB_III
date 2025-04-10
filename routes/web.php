<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ImagenController;


Route::get('/', [PropiedadController::class, 'index'])->name('index');


// Propiedades
Route::get('/propiedades/{id}', [PropiedadController::class, 'show'])->name('propiedades.show');
Route::get('/propiedades/todas', [PropiedadController::class, 'showAll'])->name('propiedades.showAll');
Route::get('/propiedades', [PropiedadController::class, 'listado'])->name('propiedades');//muestra todas de acuerdo a los filtros

Route::post('/propiedades/{id}/destacar', [PropiedadController::class, 'toggleDestacado'])
    ->middleware('auth')
    ->name('propiedades.destacar');


Route::middleware('auth')->group(function () {
    Route::get('/propiedad/registrarPropiedad', [PropiedadController::class, 'create'])->name('propiedades.create');
    Route::post('/propiedades', [PropiedadController::class, 'store'])->name('propiedades.store');
});

//editar ------ propiedad
Route::get('/propiedades/{id}/editar', [PropiedadController::class, 'edit'])->name('propiedades.edit')->middleware('auth');
Route::put('/propiedades/{id}', [PropiedadController::class, 'update'])->name('propiedades.update')->middleware('auth');

//imagenes(crud)
Route::delete('/imagenes/{id}', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
Route::put('/imagenes/{id}', [ImagenController::class, 'update'])->name('imagenes.update');
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');


// Contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto');
Route::post('/enviar-mensaje', [ContactoController::class, 'enviar'])->name('enviar.mensaje');


// Autenti
Route::get('/registro', [AuthController::class, 'registro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrarUsuario'])->name('registro.store');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'autenticar'])->name('autenticar');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Perfil
Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil')->middleware('auth');
Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar')->middleware('auth');
