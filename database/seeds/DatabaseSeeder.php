<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(MonthTableSeeder::class);
        //$this->call(AreaTableSeeder::class);
        //$this->call(QuestionTableSeeder::class);
        $this->call(PreferenceTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        //$this->call(SchoolTableSeeder::class);
    }
}
