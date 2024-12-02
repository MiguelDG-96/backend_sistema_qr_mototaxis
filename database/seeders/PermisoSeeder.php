<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permisos')->insert([
            [
                'id_vehiculo' => 1, // ID de un vehículo existente
                'id_conductor' => 1, // ID de un conductor existente
                'codigo_qr' => 'https://example.com/qr/permiso1',
                'fecha_emision' => '2024-01-01',
                'fecha_expiracion' => '2024-12-31',
                'estado' => 'Vigente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_vehiculo' => 2, // ID de otro vehículo existente
                'id_conductor' => 2, // ID de otro conductor existente
                'codigo_qr' => 'https://example.com/qr/permiso2',
                'fecha_emision' => '2023-01-01',
                'fecha_expiracion' => '2023-12-31',
                'estado' => 'Expirado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_vehiculo' => 3, // ID de otro vehículo existente
                'id_conductor' => 3, // ID de otro conductor existente
                'codigo_qr' => 'https://example.com/qr/permiso3',
                'fecha_emision' => '2024-06-01',
                'fecha_expiracion' => '2025-05-31',
                'estado' => 'Suspendido',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
