<?php

use Illuminate\Database\Seeder;
use sifmedtec\Department;
use sifmedtec\City;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(['name' => 'Petén']);
        City::create(['name' => 'San Benito', 'department_id' => 1]);
    }
}
