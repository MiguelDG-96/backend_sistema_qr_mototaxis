<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permisos para el rol Admin
        $adminPermisos = [
            1, // ver_usuarios
            2, // editar_usuarios
            3, // eliminar_usuarios
            4, // ver_roles
            5, // editar_roles
            6, // eliminar_roles
        ];
        foreach ($adminPermisos as $permisoId) {
            DB::table('rol_permisos')->insert([
                'rol_id' => 1, // ID del rol Admin
                'permiso_acceso_id' => $permisoId,
            ]);
        }

        // Permisos para el rol Usuario
        $usuarioPermisos = [
            1, // ver_usuarios
        ];
        foreach ($usuarioPermisos as $permisoId) {
            DB::table('rol_permisos')->insert([
                'rol_id' => 2, // ID del rol Usuario
                'permiso_acceso_id' => $permisoId,
            ]);
        }

        // Permisos para el rol Supervisor
        $supervisorPermisos = [
            1, // ver_usuarios
            4, // ver_roles
        ];
        foreach ($supervisorPermisos as $permisoId) {
            DB::table('rol_permisos')->insert([
                'rol_id' => 3, // ID del rol Supervisor
                'permiso_acceso_id' => $permisoId,
            ]);
        }
    }
}
