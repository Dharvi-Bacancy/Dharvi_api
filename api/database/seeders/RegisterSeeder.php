<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('register')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin_123',
            'password' => Hash::make('Admin@123'),
            'type' => 'admin',
        ]);
    }
}
