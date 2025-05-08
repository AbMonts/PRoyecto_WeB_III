<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Barryvdh\Snappy\Facades\SnappyPdf;

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
    $ventasEnZona = 25;
    $precioPromedioZona = 1700;
    $ratioGastosIngresos = 16.7;

    return view('reporte.reportePDF', compact('propiedad', 'ventasEnZona', 'precioPromedioZona', 'ratioGastosIngresos'));
}


public function generarPDF($id)
{
    $propiedad = Propiedad::with(['usuario', 'agente', 'imagenes'])->findOrFail($id);
    $ventasEnZona = 25;
    $precioPromedioZona = 1700;
    $ratioGastosIngresos = 16.7;

    $pdf = SnappyPdf::loadView('reporte.reportePDF', compact(
        'propiedad',
        'ventasEnZona',
        'precioPromedioZona',
        'ratioGastosIngresos'
    ));

    return $pdf->download('reporte-propiedad.pdf');
}


}
