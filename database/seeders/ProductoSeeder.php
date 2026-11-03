<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'sku' => 'B07VCYPTG3',
                'nombre' => 'Nescafe Reserva Cafe Soluble Liofilizado de Chiapas Frasco de 180g',
                'descripcion_corta' => 'Café 100% puro soluble liofilizado',
                'descripcion_larga' => 'Frasco de 180g; contiene cafeína
Café 100% soluble liofilizado de la verde región de Chiapas
Café con notas amaderadas
Agrega 2g de Nescafé Reserva Xiapan a tu taza favorita, sirve 150ml de agua caliente, leche o crema para café y disfruta
Frasco de vidrio que mantiene su inigualable aroma y sabor
Frasco de vidrio: Solamente limpia el frasco y su tapa, desprende la etiqueta, ¡y dale la segunda vida que prefieras! Tu frasco puede servir para muchas cosas distintas.',
                'precio_mxn' => 112.00,
                'precio_usd' => 40.00,
                'imagen' => '',
                'stock' => 100,
                'fecha_vigencia' => '2027-01-10',
                'activo' => true,
                'categoria' => 'alimentos_bebidas'
            ],
            [
                'sku' => 'B00B9ZZNUM',
                'nombre' => 'Nescafe Clasico Cafe 100% Puro Soluble Frasco de 200g',
                'descripcion_corta' => 'Café 100% puro soluble liofilizado',
                'descripcion_larga' => 'El café soluble preferido de los mexicanos desde hace más de 75 años.
Elaborado con una combinación de granos de café robusta y arábica.
Café de origen natural, a través de un proceso de secado especial.
Café soluble de sabor y aroma tradicionales incomparables.
Prepara la taza de café perfecta: una cucharadita en 150ml de agua.',
                'precio_mxn' => 134.00,
                'precio_usd' => 50.00,
                'imagen' => '',
                'stock' => 50,
                'fecha_vigencia' => '2027-01-10',
                'activo' => true,
                'categoria' => 'alimentos_bebidas'
            ],
        ]);
    }
}
