<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456'
        ]);

        User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => '123456',
        ]);

        User::create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => '123456',
        ]);
    }
}
