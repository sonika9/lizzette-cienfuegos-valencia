<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    protected $fillable = ['folio', 'email', 'subtotal', 'impuestos', 'total', 'estatus', 'fecha'];
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
    protected $casts = [
        'fecha' => 'datetime',
    ];
}
