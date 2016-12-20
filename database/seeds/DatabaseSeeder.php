<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'first_name' => 'Hossam',
            'last_name' => 'Ahmed',
            'email' => 'theprincehossam2008@gmail.com',
            'password' => '12345678',
            'role' => 1
        ]);

        DB::table('users')->insert([
            'first_name' => 'Mohamed',
            'last_name' => 'El Zarei',
            'email' => 'mohamedelzarei@gmail.com',
            'password' => 'helloworld',
            'role' => 1
        ]);

    }
}
