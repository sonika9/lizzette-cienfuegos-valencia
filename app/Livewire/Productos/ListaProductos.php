<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;
use Livewire\WithPagination;

class ListaProductos extends Component
{
    use withPagination;
    public string $busqueda = '';
    public ?int $idProducto;
    public ?int $idProductoStatus;
    public string $statusProducto = '';
    public function render()
    {
        $productos = Producto::query()
            ->when($this->busqueda, function ($query) {
                $query->where('nombre', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('sku', 'like', '%' . $this->busqueda . '%');
            })
            ->paginate(10);
        return view('livewire.productos.lista-productos', [
            'productos' => $productos,
        ]);
    }

    public function eliminarProducto(int $id)
    {
        if ($this->idProducto !== $id) {
            return;
        }

        $producto = Producto::find($id);

        $producto->delete();

        $this->idProducto = null;

        $this->dispatch('productoEliminado');
    }

    public function confirmarEliminarProducto(int $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return;
        }

        $this->idProducto = $id;
    }
    public function cambiarStatusProducto(int $id)
    {
        if ($this->idProductoStatus !== $id) {
            return;
        }

        $producto = Producto::find($id);

        $producto->activo = !$producto->activo;

        $producto->save();

        $this->idProductoStatus = null;

        $this->dispatch('statusProductoCambiado');
    }

    public function confirmarCambiarStatusProducto(int $id, bool $activo)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return;
        }

        $this->statusProducto = $activo ? 'Desactivar' : 'Activar';
        $this->idProductoStatus = $id;
    }
}
