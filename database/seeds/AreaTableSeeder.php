<?php

use Illuminate\Database\Seeder;
use sifmedtec\Area;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'id' => 1,
            'name' => 'Hardware'
        ]);
        Area::create([
            'id' => 2,
            'name' => 'Software'
        ]);
    }
}
