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
            'firstName' => "FYP",
            'lastName' => 'Admin',
            'username' => "fypadmin",
            'email' => "admin@fypalloc.com",
            'sun' => null,
            'role' => "Module Leader",
            'password' => Hash::make('admin'),
            'bio' => "This is my bio. I am the main head of the system",
        ]);

        User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => null,
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
            'bio' => "This is my bio. I focus on tech stuff",
        ]);

        User::create([
            'firstName' => "Student 1",
            'lastName' => 'User',
            'username' => "student1",
            'email' => "student1@fypalloc.com",
            'sun' => '987654321',
            'role' => "Student",
            'programme' => "BSc Computer Science",
            'password' => Hash::make('student1'),
        ]);

        User::create([
            'firstName' => "Student2",
            'lastName' => 'User',
            'username' => "student2",
            'email' => "student2@fypalloc.com",
            'sun' => '197461038',
            'role' => "Student",
            'programme' => "BSc Computer Science with Business",
            'password' => Hash::make('student2'),
        ]);

        User::create([
            'firstName' => "Guest",
            'lastName' => 'User',
            'username' => "guest",
            'email' => "guest@fypalloc.com",
            'sun' => '000000000',
            'role' => "Student",
            'programme' => "Guest Mode",
            'password' => Hash::make('guest'),
        ]);
    }
}
