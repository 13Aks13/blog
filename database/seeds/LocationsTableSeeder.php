<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'title' => 'Krakow',
        ]);

        DB::table('locations')->insert([
            'title' => 'Kherson',
        ]);

        DB::table('locations')->insert([
            'title' => 'Lviv',
        ]);
    }
}
