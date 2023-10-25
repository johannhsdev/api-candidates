<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario tester
        User::factory()->customUser()->create();

        // Crear 5 usuarios aleatorios
        User::factory()->count(5)->create();
    }
}
