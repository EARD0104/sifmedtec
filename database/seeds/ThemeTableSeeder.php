<?php

use Illuminate\Database\Seeder;
use sifmedtec\Area;
use sifmedtec\Theme;

class ThemeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Area::all() as $area) {
            factory(Theme::class)->times(10)->create(['area_id' => $area->id]);
        }
    }
}
