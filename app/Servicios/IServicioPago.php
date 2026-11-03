<?php

namespace App\Servicios;
use App\Models\Pedido;

interface IServicioPago
{
    public function realizarPago(string $email, float $total): array;
}
