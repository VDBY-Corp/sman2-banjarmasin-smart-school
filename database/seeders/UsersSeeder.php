<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("qwerqwer")
        ]);

        User::insert([
            'name' => 'gojoh',
            'email' => 'gojoh@gmail.com',
            'password' => Hash::make("qwerqwer")
        ]);
    }
}
