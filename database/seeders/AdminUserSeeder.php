<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::whereEmail('admin@yandex.ru')->exists()) {
            User::create([
                'name'     => 'Admin',
                'email'    => 'admin@yandex.ru',
                'password' => 'admin',
                'role'     => 'admin',
            ]);
        }
    }
}
