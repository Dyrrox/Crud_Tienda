<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class create_product extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product')->insert([
            [
                'nombre' => 'Pan de Molde',
                'categoria' => 'Alimnentos',
                'precio' => 10.99,
                'inventario' => 100,
            ],
            [
                'nombre' => 'Camisa',
                'categoria' => 'Ropa',
                'precio' => 19.99,
                'inventario' => 50,
            ],
            [
                'nombre' => 'Escoba',
                'categoria' => 'Hogar',
                'precio' => 5.99,
                'inventario' => 200,
            ],
        ]);
    }
}
