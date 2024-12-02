<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reportes')->insert([
            [
                'id_usuario' => 1, // ID de un usuario existente
                'tipo_reporte' => 'Permisos por vencer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => 2, // ID de otro usuario existente
                'tipo_reporte' => 'Permisos vencidos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => null, // Reporte general sin usuario específico
                'tipo_reporte' => 'Asociaciones inscritas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
