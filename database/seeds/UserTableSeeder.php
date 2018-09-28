<?php

use Illuminate\Database\Seeder;
use sifmedtec\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'secret',
            'api_token' => str_random(100),
            'role_id' => 1
        ]);
    }
}
