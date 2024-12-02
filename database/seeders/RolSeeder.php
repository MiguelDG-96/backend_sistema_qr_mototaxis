<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rols')->insert([
            [
                'nombre' => 'Admin',
                'descripcion' => 'Administrador del sistema con acceso total',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Usuario',
                'descripcion' => 'Usuario regular con acceso limitado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Supervisor',
                'descripcion' => 'Supervisor con acceso a módulos específicos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
