<?php
namespace App\Servicios;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ExchangeRateAPI implements ITipoCambio
{
    public function obtenerTipoCambio(): float
    {
        $tipoCambio = Cache::get('tipo_cambio');
        if ($tipoCambio) {
            return $tipoCambio;
        }
        $api = 'https://open.er-api.com/v6/latest/USD';
        $response = Http::get($api);
        Cache::put('tipo_cambio', $response['rates']['MXN'], now()->addHours(2));

        return $response['rates']['MXN'];
    }
}
