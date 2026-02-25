<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items = [
            ['nombre' => 'Cemento 50kg',           'cantidad' => 25,  'estatus' => 1],
            ['nombre' => 'Varilla 3/8',            'cantidad' => 120, 'estatus' => 1],
            ['nombre' => 'Arena (m3)',             'cantidad' => 8,   'estatus' => 1],
            ['nombre' => 'Grava (m3)',             'cantidad' => 6,   'estatus' => 1],
            ['nombre' => 'Pintura blanca 19L',     'cantidad' => 14,  'estatus' => 1],
            ['nombre' => 'Cable calibre 12 (m)',   'cantidad' => 250, 'estatus' => 1],
            ['nombre' => 'Clavos 2" (kg)',         'cantidad' => 18,  'estatus' => 1],
            ['nombre' => 'Tornillos 1/2" (caja)',  'cantidad' => 30,  'estatus' => 1],
            ['nombre' => 'Guantes de seguridad',   'cantidad' => 60,  'estatus' => 1],
            ['nombre' => 'Casco de seguridad',     'cantidad' => 10,  'estatus' => 0], // inactivo a propósito
        ];

        foreach ($items as $item) {
            Producto::updateOrCreate(
                ['nombre' => $item['nombre']],
                $item
            );
        }
    }
}
