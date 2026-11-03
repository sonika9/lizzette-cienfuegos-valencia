<?php

namespace App\Livewire\Tienda;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use App\Servicios\IServicioPago;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ListaProductos extends Component
{
    use WithPagination;

    public string $categoria = '';
    public array $carritoProductos = [];
    public ?int $productoIdSeleccionado = null;
    public ?int $productoIdRemover = null;
    public string $tipoBloque = 'lista_productos';
    public array $productosCarritoDetalle = [];
    public float $subtotal = 0.0;
    public float $iva = 0.0;
    public float $total = 0.0;
    public string $email = '';
    public string $pagoProcesadoMensaje = '';
    public ?bool $pagoProcesado = null;
    public bool $emailError = false;
    public ?Producto $productoSeleccionado = null;
    public ?int $productoSeleccionadoId = null;
    public ?int $disponibilidad = null;
    public ?int $precio = null;

    public function mount()
    {
        $this->carritoProductos = session()->get('carritoProductos', []);
    }

    public function render()
    {
        $productos = Producto::query()
            ->when($this->categoria, function ($query) {
                $query->where('categoria', $this->categoria);
            })
            ->when($this->disponibilidad && $this->disponibilidad == 1, function ($query) {
                $query->where('stock', '>', 0);
            })
            ->when($this->precio && $this->precio == 1, function($query) {
                $query->where('precio_mxn', '<', 100);
            })
            ->when($this->precio && $this->precio == 2, function($query) {
                $query->whereBetween('precio_mxn', [100, 500]);
            })
            ->when($this->precio && $this->precio == 3, function($query) {
                $query->whereBetween('precio_mxn', [500, 1000]);
            })
            ->when($this->precio && $this->precio == 4, function($query) {
                $query->where('precio_mxn', '>', 1000);
            })
            ->paginate(10);
        return view('livewire.tienda.lista-productos', [
            'productos' => $productos,
        ])->layout('layouts.tienda', ['title' => 'Lista de Productos']);
    }

    public function incrementarCantidadCarrito(int $productoId)
    {
        $producto = Producto::find($productoId);
        if (!$producto) {
            return;
        }
        $cantidadActual = isset($this->carritoProductos[$productoId]) ? $this->carritoProductos[$productoId] : 0;
        if ($cantidadActual < $producto->stock) {
            $this->carritoProductos[$productoId] = $cantidadActual + 1;
            $this->calcularTotales();
        }
        session()->put('carritoProductos', $this->carritoProductos);
    }

    public function decrementarCantidadCarrito(int $productoId)
    {
        $producto = Producto::find($productoId);
        if (!$producto) {
            return;
        }
        if (isset($this->carritoProductos[$productoId]) && $this->carritoProductos[$productoId] > 0) {
            $this->carritoProductos[$productoId] =
                isset($this->carritoProductos[$productoId]) ?
                    $this->carritoProductos[$productoId] - 1 : 0;
            $this->calcularTotales();
        }
        session()->put('carritoProductos', $this->carritoProductos);
    }

    public function removerProductoDelCarrito(int $productoId)
    {
        unset($this->carritoProductos[$productoId]);
        $this->calcularTotales();
        session()->put('carritoProductos', $this->carritoProductos);
    }

    public function updatedTipoBloque(string $tipoBloque)
    {
        if ($tipoBloque === 'carrito') {
            $this->productosCarritoDetalle = Producto::query()
                ->whereIn('id', array_keys($this->carritoProductos))
                ->get()->toArray();
            $this->calcularTotales();
        }
    }

    public function calcularTotales()
    {
        foreach ($this->productosCarritoDetalle as $producto) {
            $this->subtotal += $producto['precio_mxn'] * ($this->carritoProductos[$producto['id']] ?? 0);
        }
        $this->iva = $this->subtotal * 0.16;
        $this->total = $this->subtotal + $this->iva;
    }

    public function updatedEmail()
    {
        $this->emailError = !filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
    public function procesarPago(IServicioPago $servicioPago)
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->emailError = true;
            return;
        }
        $respuesta = $servicioPago->realizarPago($this->email, $this->total);

        if (!$respuesta['status']) {
            $this->pagoProcesado = false;
            $this->pagoProcesadoMensaje = $respuesta['mensaje'];
            return;
        }
        $carritoProductos = $this->carritoProductos;
        DB::transaction(function () use ($carritoProductos) {
            $pedido = Pedido::create([
                'folio' => 0,
                'email' => $this->email,
                'subtotal' => $this->subtotal,
                'impuestos' => $this->iva,
                'total' => $this->total,
                'estatus' => 'pagado',
                'fecha' => now()
            ]);
            $pedido->folio = 'PEDIDO_' . $pedido->id;
            $pedido->save();

            foreach ($this->carritoProductos as $productoId => $cantidad) {
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $productoId,
                    'cantidad' => $cantidad,
                    'precio_mxn' => collect($this->productosCarritoDetalle)->where('id', $productoId)->first()['precio_mxn'],
                    'precio_usd' => collect($this->productosCarritoDetalle)->where('id', $productoId)->first()['precio_usd']
                ]);

                $stockActualizado = Producto::where('id', $productoId)
                    ->where('stock', '>=', $cantidad)
                    ->decrement('stock', $cantidad);
                if (!$stockActualizado) {
                    throw new Exception("El producto con ID {$productoId} no esta disponible");
                }
            }
            $this->pagoProcesado = true;
            $this->pagoProcesadoMensaje = 'Pago realizado con éxito';
            $this->tipoBloque = 'confirmacion';
            $this->carritoProductos = [];
            session()->put('carritoProductos', $this->carritoProductos);
        });
    }
    public function updatedProductoSeleccionadoId(int $productoSeleccionadoId)
    {
        $this->productoSeleccionado = Producto::where('id', $productoSeleccionadoId)->first();
        $this->tipoBloque = 'detalle';
    }
}
