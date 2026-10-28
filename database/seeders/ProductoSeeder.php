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
        $productos = [
            [
                'nombre' => 'Churro sencillo sin relleno',
                'descripcion' => 'Churro tradicional sin relleno.',
                'precio' => 30.00,
            ],

            [
                'nombre' => 'Churro con cajeta',
                'descripcion' => 'Churro relleno de cajeta.',
                'precio' => 35.00,
            ],
            [
                'nombre' => 'Churro con Nutella',
                'descripcion' => 'Churro relleno de Nutella.',
                'precio' => 35.00,
            ],
            [
                'nombre' => 'Churro con mermelada de fresa',
                'descripcion' => 'Churro relleno de mermelada de fresa.',
                'precio' => 35.00,
            ],
            [
                'nombre' => 'Churro con chocolate',
                'descripcion' => 'Churro relleno de chocolate.',
                'precio' => 35.00,
            ],
            [
                'nombre' => 'Churro con mermelada de frambuesa',
                'descripcion' => 'Churro relleno de mermelada de frambuesa.',
                'precio' => 35.00,
            ],
            [
                'nombre' => 'Churro con lechera',
                'descripcion' => 'Churro relleno de lechera.',
                'precio' => 35.00,
            ],

            [
                'nombre' => 'Churro de cajeta y Philadelphia',
                'descripcion' => 'Churro combinado con cajeta y queso Philadelphia.',
                'precio' => 40.00,
            ],
            [
                'nombre' => 'Churro de Nutella y Philadelphia',
                'descripcion' => 'Churro combinado con Nutella y queso Philadelphia.',
                'precio' => 40.00,
            ],
            [
                'nombre' => 'Churro de mermelada de fresa y Philadelphia',
                'descripcion' => 'Churro combinado con mermelada de fresa y queso Philadelphia.',
                'precio' => 40.00,
            ],
            [
                'nombre' => 'Churro de chocolate y Philadelphia',
                'descripcion' => 'Churro combinado con chocolate y queso Philadelphia.',
                'precio' => 40.00,
            ],
            [
                'nombre' => 'Churro de mermelada de frambuesa y Philadelphia',
                'descripcion' => 'Churro combinado con mermelada de frambuesa y queso Philadelphia.',
                'precio' => 40.00,
            ],
            [
                'nombre' => 'Churro de lechera y Philadelphia',
                'descripcion' => 'Churro combinado con lechera y queso Philadelphia.',
                'precio' => 40.00,
            ],
        ];

        foreach ($productos as $datos) {
            Producto::updateOrCreate(
                ['nombre' => $datos['nombre']],
                [
                    'descripcion' => $datos['descripcion'],
                    'precio' => $datos['precio'],
                    'disponible' => true,
                ]
            );
        }
    }
}
