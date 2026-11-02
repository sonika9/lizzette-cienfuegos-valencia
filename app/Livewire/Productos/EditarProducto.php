<?php

namespace App\Livewire\Productos;

use App\Livewire\Forms\ProductoForm;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditarProducto extends Component
{
    use withFileUploads;

    public ProductoForm $form;

    public function mount(Producto $producto)
    {
        $this->form->setProducto($producto);
    }

    public function render()
    {
        return view('livewire.productos.editar-producto');
    }

    public function editarProducto()
    {
        $this->form->update();
        return $this->redirect('/productos');
    }
}
