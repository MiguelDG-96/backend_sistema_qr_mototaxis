<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'mdolicg@gmail.com',
            'password' => Hash::make('1996'), // Cambia 'password' por una contraseña segura
            'id_rol' => 18, // Suponiendo que tienes un rol "Admin" con ID 1
            'estado' => 1, // Usuario activo
        ]);

        // User::create([
        //     'name' => 'Usuario',
        //     'email' => 'user@example.com',
        //     'password' => Hash::make('password'), // Cambia 'password' por otra contraseña segura
        //     'id_rol' => 2, // Suponiendo que tienes un rol "Usuario" con ID 2
        //     'estado' => 1, // Usuario activo
        // ]);
    }
}
