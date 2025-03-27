<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// -----------------------inicio
Route::get('/auth/inicio', function () {
    return view('index');
});

// -------------------------login
Route::get('/auth/login', function () {
    return view('login');
});

//------------- perfil
Route::get('/perfil', function () {
    return view('perfil');
});

//----------------- propiedades
Route::get('/propiedad/propiedades', function () {
    return view('propiedades');
});

// -----------------detalles de una propiedad (param)
Route::get('/propiedad/propiedad/{id}', function ($id) {
    return view('detalles', ['id' => $id]);
});

// -------------------contacto
Route::get('/contacto', function () {
    return view('contacto');
});

//--------------------registro de usuario
Route::get('/auth/registro', function () {
    return view('registro');
});

// --------------------registro de propiedad
Route::get('/propiedad/registrar_propiedad', function () {
    return view('registrar_propiedad');
});
