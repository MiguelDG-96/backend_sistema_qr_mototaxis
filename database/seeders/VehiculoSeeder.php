<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehiculos')->insert([
            [
                'placa' => 'ABC123',
                'marca' => 'Honda',
                'modelo' => 'Wave 110',
                'anio' => 2020,
                'id_conductor' => 1, // ID de un conductor existente
                'estado' => 1, // Activo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'placa' => 'DEF456',
                'marca' => 'Yamaha',
                'modelo' => 'Crypton',
                'anio' => 2021,
                'id_conductor' => 2, // ID de otro conductor existente
                'estado' => 1, // Activo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'placa' => 'GHI789',
                'marca' => 'Suzuki',
                'modelo' => 'GN125',
                'anio' => 2019,
                'id_conductor' => 3, // ID de otro conductor existente
                'estado' => 0, // Inactivo
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
