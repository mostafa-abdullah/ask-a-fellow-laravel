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
            'first_name' => 'Mostafa',
            'last_name' => 'Abdullah',
            'email' => 'mostafaabdullahahmed@gmail.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        DB::table('users')->insert([
            'first_name' => 'FName1',
            'last_name' => 'LName1',
            'email' => 'email1@email.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        DB::table('users')->insert([
            'first_name' => 'FName2',
            'last_name' => 'LName2',
            'email' => 'email2@email.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        DB::table('users')->insert([
            'first_name' => 'FName3',
            'last_name' => 'LName3',
            'email' => 'email3@email.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        DB::table('users')->insert([
            'first_name' => 'FName4',
            'last_name' => 'LName4',
            'email' => 'email4@email.com',
            'password' => bcrypt('password'),
            'role' => 1
        ]);

        DB::table('majors')->insert([
            'major' => 'Computer Science and Engineering',
            'Faculty' => 'Media Engineering and Technology',
        ]);

        DB::table('majors')->insert([
            'major' => 'Digital Media Engineering and Technology',
            'Faculty' => 'Media Engineering and Technology',
        ]);

        DB::table('majors')->insert([
            'major' => 'General Engineering',
            'Faculty' => 'General Engineering',
        ]);

        DB::table('majors')->insert([
            'major' => 'Pharmacy',
            'Faculty' => 'Pharmacy and Biotechnology',
        ]);

        DB::table('majors')->insert([
            'major' => 'Business Informatics',
            'Faculty' => 'Management Technology',
        ]);


        DB::table('courses')->insert([
            'course_code' => 'CSEN102',
            'course_name' => 'Introduction to Computer Science',
        ]);


        DB::table('courses')->insert([
            'course_code' => 'CSEN202',
            'course_name' => 'Introduction to Computer Programming',
        ]);

        DB::table('courses')->insert([
            'course_code' => 'CSEN302',
            'course_name' => 'Data Structures and Algorithms',
        ]);

    }
}
