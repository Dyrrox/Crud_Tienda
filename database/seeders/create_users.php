<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class create_users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'nombre' => 'Erik Casillas',
                'usuario' => 'erik1804',
                'email' => 'qwerty@gmail.com',
                'clave' => 123456,
                'cargo' => 1,
            ],
            [
                'nombre' => 'Rubi Casillas',
                'usuario' => 'grace1804',
                'email' => 'rubi_casillaas31@hotmail.com',
                'clave' => 123456,
                'cargo' => 1,
            ],
        ]);
    }
}
