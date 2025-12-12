<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Page;
use Illuminate\Database\Seeder;
use App\Models\User;

class PrimarySeeder extends Seeder
{
    /**
     * Створення Адміна
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => 'password',
            'role' => 'admin',
        ]);
        $user->addMediaFromUrl('https://w3schoolsua.github.io/images/admin.png')
            ->toMediaCollection('avatar');

        Page::create([
            'id' => '1',
            'name' => 'Головна',
            'content' => 'Вітаємо на сайті',
            'slug' => 'home',
            'template' => 'home',
        ]);
    }
}
