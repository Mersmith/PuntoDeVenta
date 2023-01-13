<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CompraController extends Controller
{
    public function pdfCompra(Compra $compra, Request $request)
    {

        $estado = $compra->estado;
        $total = $compra->total;
        $impuesto = $compra->impuesto;
        $proveedor = $compra->proveedor->nombre;
        $personal = $compra->user->email;
        $fecha = $compra->created_at;

        $detalle_compra = $compra->compraDetalle;

        $data = [
            'titulo' => 'Factura Comercial',
            'fecha_descarga' => date('m/d/Y'),
            'estado' => $estado,
            'total' => $total,
            'impuesto' => $impuesto,
            'proveedor' => $proveedor,
            'personal' => $personal,
            'fecha' => $fecha,
            'detalle_compra' => $detalle_compra
        ];

        $pdf = Pdf::loadView('pdf.factura-compra', $data);

        return $pdf->download('factura-compra.pdf');
    }
}
