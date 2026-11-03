<?php

namespace App\Livewire\Pedidos;

use App\Models\Pedido;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ListaPedidos extends Component
{

    use withPagination;

    public $fechaInicio;
    public $fechaFin;

    public function render()
    {
        $pedidos = Pedido::query()
            ->when($this->fechaInicio && $this->fechaFin, function ($query) {
                $query->whereBetween('fecha', [
                    $this->fechaInicio . ' 00:00:00',
                    $this->fechaFin . ' 23:59:59',
                ]);
            })->paginate(10);
        return view('livewire.pedidos.lista-pedidos', ['pedidos' => $pedidos]);
    }
    public function updatedFechaInicio()
    {
        $this->resetPage();
    }
    public function updatedFechaFin()
    {
        $this->resetPage();
    }
}
