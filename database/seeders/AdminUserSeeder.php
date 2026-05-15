<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::whereEmail('ecriuchkov@yandex.ru')->exists()) {
            User::create([
                'name'     => 'Egor',
                'email'    => 'ecriuchkov@yandex.ru',
                'password' => 'POIlkj#175%',
                'role'     => 'admin',
            ]);
        }
    }
}
