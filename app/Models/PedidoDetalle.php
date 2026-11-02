<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'precio_usd', 'precio_mxn'];
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
