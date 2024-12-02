<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoAccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permisos_acceso')->insert([
            [
                'nombre' => 'ver_usuarios',
                'descripcion' => 'Permiso para visualizar la lista de usuarios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'editar_usuarios',
                'descripcion' => 'Permiso para editar información de usuarios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'eliminar_usuarios',
                'descripcion' => 'Permiso para eliminar usuarios del sistema',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'ver_roles',
                'descripcion' => 'Permiso para visualizar la lista de roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'editar_roles',
                'descripcion' => 'Permiso para editar los roles del sistema',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'eliminar_roles',
                'descripcion' => 'Permiso para eliminar roles del sistema',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
