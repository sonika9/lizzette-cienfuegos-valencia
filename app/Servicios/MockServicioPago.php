<?php

namespace App\Servicios;

use App\Models\Pedido;

class MockServicioPago implements IServicioPago {
    public function realizarPago(string $email, float $total): array {
        sleep(2);
        return [
            'status' => true,
            'mensaje' => 'Pago realizado con éxito',
        ];
    }
}
