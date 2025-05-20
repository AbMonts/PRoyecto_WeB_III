<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\SolicitudClienteAgente;

class ReportePropiedadController extends Controller
{
    public function seleccionar()
    {
        $propiedades = Propiedad::with('usuario')->get();
        return view('reporte.selecc', compact('propiedades'));
    }

   

public function mostrar($id)
{
    $propiedad = Propiedad::with(['usuario', 'imagenes', 'ventas', 'mensajes', 'historialVistas', 'destacadaPor'])->findOrFail($id);

    // Datos adicionales
    $ventasEnZona = 25;
    $precioPromedioZona = 1700;
    $ratioGastosIngresos = 16.7;

    // Buscar agente asignado si existe una solicitud aprobada por ambas partes
    $solicitudAgente = SolicitudClienteAgente::with('agente')
        ->where('propiedad_id', $propiedad->id)
        ->where('cliente_id', $propiedad->usuario_id)
        ->where('estado', 'Aprobado')
        ->where('aprobado_por_subadmin', true)
        ->where('aprobado_por_cliente', true)
        ->first();

    return view('reporte.reportePDF', compact(
        'propiedad',
        'ventasEnZona',
        'precioPromedioZona',
        'ratioGastosIngresos',
        'solicitudAgente'
    ));
}


public function generarPDF($id)
{
    $propiedad = Propiedad::with(['usuario', 'agente', 'imagenes'])->findOrFail($id);
    $ventasEnZona = 25;
    $precioPromedioZona = 1700;
    $ratioGastosIngresos = 16.7;

    $solicitudAgente = SolicitudClienteAgente::with('agente')
    ->where('propiedad_id', $propiedad->id)
    ->where('cliente_id', $propiedad->usuario_id)
    ->where('estado', 'Aprobado')
    ->where('aprobado_por_subadmin', true)
    ->where('aprobado_por_cliente', true)
    ->first();


    $pdf = SnappyPdf::loadView('reporte.reportePDF', compact(
        'propiedad',
        'ventasEnZona',
        'precioPromedioZona',
        'ratioGastosIngresos',
        'solicitudAgente'
    ));


    return $pdf->download('reporte-propiedad.pdf');
}


}
