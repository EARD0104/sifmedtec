<?php

use Illuminate\Database\Seeder;
use sifmedtec\School;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(School::class)->create(['name' => '3 de Abril','city_id' => 1]);
    }
}
