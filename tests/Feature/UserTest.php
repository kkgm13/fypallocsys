<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser, $studentUser, $supervisorUser;

    /** @test */
    public function student_access_edit_page(){
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $response = $this->actingAs($this->studentUser)
            ->get(route('users.edit', $this->studentUser));

        $response->assertStatus(404);
    }

    /** @test */
    public function supervisor_access_edit_page(){
        // Create Supervisor User
        $this->supervisorUser = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => "192837465",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
        ]);

        $response = $this->actingAs($this->supervisorUser)
            ->get(route('users.edit', $this->supervisorUser));

        $response->assertOk();
    }

    /** @test */
    public function leaders_access_edit_page(){
        // Create Admin User
        $this->adminUser = User::create([
            'firstName' => "Admin",
            'lastName' => 'User',
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);
        $response = $this->actingAs($this->adminUser)
            ->get(route('users.edit', $this->adminUser));

        $response->assertOk();
    }
}
