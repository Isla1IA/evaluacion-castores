<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('nombre', 'administrador')->first();
        $almacenistaRole = Role::where('nombre', 'almacenista')->first();

        User::firstOrCreate(
            ['email' => 'admin@castores.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'estatus' => 1,
            ]
        );
        User::firstOrCreate(
            ['email' => 'almacenista@castores.com'],
            [
                'name' => 'Almacenista User',
                'password' => Hash::make('password'),
                'role_id' => $almacenistaRole->id,
                'estatus' => 1,
            ]
        );
    }
}
