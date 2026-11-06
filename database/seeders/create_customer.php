<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class create_customer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'nombre' => 'John Doe',
                'genero' => 'Masculino',
                'telefono' => '123456789',
                'dni' => '12345678',
            ],
            [
                'nombre' => 'Jane Smith',
                'genero' => 'Femenino',
                'telefono' => '987654321',
                'dni' => '87654321',
            ],
        ]);
    }
}
