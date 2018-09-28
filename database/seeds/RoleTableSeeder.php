<?php

use Illuminate\Database\Seeder;
use sifmedtec\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 1,
            'name' => 'admin'
        ]);
        Role::create([
            'id' => 2,
            'name' => 'guest'
        ]);
        Role::create([
            'id' => 3,
            'name' => 'reporter'
        ]);
    }
}
