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
use App\Http\Controllers\MensajeInteraccionController;
use App\Http\Controllers\ReportePropiedadController;
use App\Http\Controllers\SolicitudPropiedadController;

Route::get('/', [PropiedadController::class, 'index'])->name('index');



Route::get('/admin/reportes', [ReportePropiedadController::class, 'seleccionar'])->name('admin.reportes');

Route::get('/reporte/seleccionar', [ReportePropiedadController::class, 'seleccionar']);
Route::get('/reporte/propiedad/{id}', [ReportePropiedadController::class, 'mostrar'])->name('reporte.mostrar');
Route::get('/reporte/seleccionar', [ReportePropiedadController::class, 'seleccionar'])->name('reporte.seleccionar');
Route::get('/reporte/pdf/{id}', [ReportePropiedadController::class, 'generarPDF'])->name('reporte.pdf');


// Propiedades
Route::get('/propiedades/{id}', [PropiedadController::class, 'show'])->name('propiedades.show');
Route::get('/propiedades/todas', [PropiedadController::class, 'showAll'])->name('propiedades.showAll');
Route::get('/propiedades', [PropiedadController::class, 'listado'])->name('propiedades');//muestra todas de acuerdo a los filtros

Route::post('/propiedades/{id}/destacar', [PropiedadController::class, 'toggleDestacado'])
    ->middleware('auth')
    ->name('propiedades.destacar');


// --------------Usuario 
Route::middleware('auth')->group(function () {
    Route::get('/solicitud/{id}/detalle', [SolicitudPropiedadController::class, 'detalle'])->name('solicitud.detalle');
    Route::get('/solicitud/propiedad', [SolicitudPropiedadController::class, 'create'])->name('solicitud.create');
    Route::post('/solicitud/propiedad', [SolicitudPropiedadController::class, 'store'])->name('solicitud.store');

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
    //RegistrarRenta
    Route::post('agente/registrar-renta/{propiedad}', [AgenteController::class, 'registrarRenta'])->name('agente.registrarRenta');
    Route::post('agente/guardar-info-cliente/{propiedad}', [AgenteController::class, 'guardarInfoCliente'])->name('agente.guardarInfoCliente');

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

    //propiedade
    Route::get('/admin/solicitudes', [AdminController::class, 'mostrarSolicitudes'])->name('solicitudes');
    Route::get('/solicitudes/{id}', [AdminSolicitudController::class, 'VerSolicitudProp'])->name('solicitudes.show');
    Route::post('/solicitudes/{id}/aprobar', [AdminSolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
    Route::post('/solicitudes/{id}/rechazar', [AdminSolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
    Route::get('/admin/solicitudes/{id}/editar', [SolicitudPropiedadController::class, 'editar'])->name('solicitudes.editar');
    Route::put('/admin/solicitudes/{id}', [SolicitudPropiedadController::class, 'actualizar'])->name('solicitudes.actualizar');

    Route::get('/propiedades/{id}/edit', [PropiedadController::class, 'editAdmin'])->name('propiedad.editAdmin');
    Route::put('/propiedades/{id}', [PropiedadController::class, 'updateAdmin'])->name('propiedad.updateAdmin');
    Route::delete('/propiedades/{id}', [PropiedadController::class, 'destroy'])->name('propiedad.destroy');

    //usuario
    Route::delete('/admin/clientes/{id}', [PerfilController::class, 'destroy'])->name('clientes.destroy');
    Route::get('/admin/clientes/{id}', [PerfilController::class, 'showCliente'])->name('clientes.show');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('admin.login');
    })->name('logout');
});


//mensajes directos agente - cliente
Route::post('/mensajes', [MensajeInteraccionController::class, 'store'])->name('mensajes.store');

//cliente agente
Route::post('/mensajes', [MensajeInteraccionController::class, 'store'])->name('mensajes.store');
