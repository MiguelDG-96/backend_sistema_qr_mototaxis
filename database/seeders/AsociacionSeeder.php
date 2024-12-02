<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsociacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asociaciones')->insert([
            [
                'nombre' => 'Asociación de Transporte Mototaxi Centro',
                'direccion' => 'Av. Principal 123, Centro',
                'telefono' => '123456789',
                'estado' => 1, // Activa
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Asociación de Transporte Mototaxi Norte',
                'direccion' => 'Calle Norte 45, Norte',
                'telefono' => '987654321',
                'estado' => 1, // Activa
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Asociación de Transporte Mototaxi Sur',
                'direccion' => 'Av. Sur 567, Sur',
                'telefono' => '654321987',
                'estado' => 0, // Inactiva
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
