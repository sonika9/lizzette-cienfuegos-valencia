<?php

namespace App\Livewire\Productos;

use App\Livewire\Forms\ProductoForm;
use \Livewire\WithFileUploads;
use Livewire\Component;


class CrearProducto extends Component
{
    use WithFileUploads;
    public ProductoForm $form;
    public function render()
    {
        return view('livewire.productos.crear-producto');
    }

    public function crearProducto()
    {
        $this->form->store();
        return $this->redirect('/productos');
    }
}
