<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\AdminLoginController;
use App\Models\Usuario;
use App\Http\Controllers\SubadminController;
use App\Http\Controllers\AgenteController;
use App\Http\Controllers\SolicitudAgenteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgenteAuthController;

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

//eliminar ---propiedad
Route::delete('/propiedades/{id}', [PropiedadController::class, 'destroy'])->name('propiedades.destroy');



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

//login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'autenticar'])->name('autenticar');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Perfil
Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil')->middleware('auth');
Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar')->middleware('auth');


//login admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

//Auth agente
Route::get('/agente/login', [AgenteAuthController::class, 'showLoginForm'])->name('agente.login');
Route::post('/agente/login', [AgenteAuthController::class, 'loginAgente'])->name('agente.login');
Route::post('/agente/logout', [AgenteAuthController::class, 'logout'])->name('agente.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/agente/dashboard', [AgenteController::class, 'dashboard'])->name('agente.dashboard');
    Route::get('/agente/solicitudes', [AgenteController::class, 'verSolicitudes'])->name('solicitudes');
    Route::get('/agente/solicitud/{id}', [AgenteController::class, 'verDetalleSolicitud'])->name('agente.solicitud.detalle');    Route::post('/agente/solicitud/{id}/aceptar', [AgenteController::class, 'aceptarSolicitud'])->name('agente.solicitud.aceptar');
    Route::post('/agente/solicitud/{id}/rechazar', [AgenteController::class, 'rechazarSolicitud'])->name('agente.solicitud.rechazar');
    Route::get('/agente/cliente/{clienteId}/propiedad', [AgenteController::class, 'verPropiedadCliente'])->name('agente.verPropiedadCliente');


    Route::delete('/agente/cancelar-asociacion/{solicitud}', [AgenteController::class, 'cancelarAsociacion'])
    ->name('agente.cancelarAsociacion');

    // Registrar venta
    Route::post('/agente/venta/{id}', [AgenteController::class, 'registrarVenta'])->name('agente.registrarVenta');
    Route::post('/agente/renta/{id}', [AgenteController::class, 'registrarRenta'])->name('agente.registrarRenta');
    
    Route::post('/agente/guardar-info-cliente/{propiedad}', [AgenteController::class, 'guardarInfoCliente'])->name('agente.guardarInfoCliente');

    //propuesta
    Route::post('/agente/mensaje/enviar', [AgenteController::class, 'enviarMensaje'])->name('agente.enviarMensaje');

        //solicitud 
    Route::post('/solicitar-agente', [SolicitudAgenteController::class, 'enviar'])->name('solicitar.agente');

});


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Subadmins
    Route::get('/subadmins', [AdminController::class, 'indexSubadmins'])->name('subadmins.index');
    Route::get('/subadmins/create', [AdminController::class, 'createSubadmin'])->name('subadmins.create');
    Route::post('/subadmins', [AdminController::class, 'storeSubadmin'])->name('subadmins.store');
    Route::get('/subadmins/{id}', [AdminController::class, 'showSubadmin'])->name('subadmins.show');
    Route::put('/subadmins/{id}', [AdminController::class, 'updateSubadmin'])->name('subadmins.update');
    Route::delete('/subadmins/{id}', [AdminController::class, 'destroySubadmin'])->name('subadmins.destroy');

    // Agentes
    Route::get('/agentes/create', [AdminController::class, 'createAgente'])->name('agentes.create');
    Route::post('/agentes', [AdminController::class, 'storeAgente'])->name('agentes.store');
    Route::get('/agentes/{id}', [AdminController::class, 'showAgente'])->name('agentes.show');
    Route::put('/agentes/{id}', [AdminController::class, 'updateAgente'])->name('agentes.update');
    Route::delete('/agentes/{id}', [AdminController::class, 'destroyAgente'])->name('agentes.destroy');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('admin.login');
    })->name('logout');
});
