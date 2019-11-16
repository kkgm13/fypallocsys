<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    protected $studentUser, $supervisorStudent;

    /** @test */
    public function a_proposal_is_created(){
        $this->studentUser = User::create([
            'name' => "Student User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "student",
            'password' => Hash::make("student"),
        ]);

        $response = $this->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->studentUser,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);
    } 
}
