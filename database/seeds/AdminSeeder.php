<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'SuperAdmin',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
            'role_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'TestUser',
            'email' => 'u@email.com',
            'password' => Hash::make('secret'),
            'role_id' => 2
        ]);

        DB::table('users')->insert([
            'name' => 'TestUser',
            'email' => 'a@email.com',
            'password' => Hash::make('secret'),
            'role_id' => 2
        ]);
    }
}
