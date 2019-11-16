<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => "FYP Admin",
            'username' => "fypadmin",
            'email' => "admin@fypalloc.com",
            'sun' => '123456789',
            'role' => "Module Leader",
            'password' => Hash::make('admin'),
        ]);

        User::create([
            'name' => "Student 1",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => '987654321',
            'role' => "Student",
            'password' => Hash::make('student'),
        ]);
    }
}
