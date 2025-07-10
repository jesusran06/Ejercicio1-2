<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'julian',
            'age' => 30,
            'password' => Hash::make('12345678'),
            'avatar' => 'avatar1.png',
            'role' => 1, // 1 indica que es administrador
        ]);

        // Crear otros usuarios con avatar por defecto
        User::factory(5)->create([
            'avatar' => 'avatar1.png'
        ]);
    }
}
