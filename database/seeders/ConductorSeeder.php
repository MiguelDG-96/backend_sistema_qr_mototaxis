<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConductorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conductores')->insert([
            [
                'nombre' => 'Juan Pérez',
                'dni' => '12345678',
                'direccion' => 'Av. Siempre Viva 123',
                'telefono' => '123456789',
                'id_asociacion' => 1, // ID de una asociación existente
                'estado' => 1, // Activo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María López',
                'dni' => '87654321',
                'direccion' => 'Calle Falsa 456',
                'telefono' => '987654321',
                'id_asociacion' => 2, // ID de otra asociación existente
                'estado' => 1, // Activo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Carlos Sánchez',
                'dni' => '11223344',
                'direccion' => 'Av. Central 789',
                'telefono' => '654321987',
                'id_asociacion' => 1, // ID de la misma asociación que el primer conductor
                'estado' => 0, // Inactivo
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
