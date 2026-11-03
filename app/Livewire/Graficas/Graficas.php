<?php

namespace App\Livewire\Graficas;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Pedido;

class Graficas extends Component
{
    public function render()
    {
        $ganancias = Pedido::query()
            ->selectRaw('MONTH(fecha) as month, SUM(total) as total')
            ->where('fecha', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()->toArray();
        $meses = array_column($ganancias, 'month');
        $valores = array_column($ganancias, 'total');

        $productosVendidos = Producto::query()
            ->join('pedido_detalles', 'productos.id', '=', 'pedido_detalles.producto_id')
            ->select('productos.nombre',
                DB::raw('SUM(pedido_detalles.cantidad) as cantidad'))
            ->where('pedido_detalles.created_at', '>=', now()->subMonths(6))
            ->groupBy('productos.nombre')
            ->orderByDesc('cantidad')
            ->limit(3)
            ->get()->toArray();

        $productos = array_column($productosVendidos, 'nombre');
        $ventas = array_column($productosVendidos, 'cantidad');

        return view('livewire.graficas.graficas', [
            'chartData' => [
                'ganancias_labels' => $meses,
                'ganancias_values' => $valores,
                'productos_labels' => $productos,
                'productos_values' => $ventas,
            ],
        ]);
    }
}
