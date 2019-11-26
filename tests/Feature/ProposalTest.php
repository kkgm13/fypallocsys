<?php

namespace Tests\Feature;

use App\Proposal;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    protected $studentUser, $supervisorUser;

    /** @test */
    public function a_proposal_is_added(){

        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $this->supervisorUser = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => "2468013579",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
        ]);

        // Submit a proposal as a Student
        $response = $this->actingAs($this->studentUser)->post('/proposals', [
            'name' => 'Proposal name',
            'description' => 'Hello World. I am a description which will state the context of what I am conveying',
            'studentID' => $this->studentUser,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());
        // $this->actingAs($this->supervisorUser)->get(route('proposals.show'));
       // Redirect
        $response->assertRedirect('/proposals/');
    } 

    /** @test */
    public function student_or_supervisor_edits_a_proposal(){
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $this->supervisorUser = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => "2468013579",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
        ]);

        $this->actingAs($this->studentUser)->post('/proposals', [
            'name' => 'Proposal name',
            'description' => 'Hello World. I am a description which will state the context of what I am conveying',
            'studentID' => $this->studentUser,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        $proposal = Proposal::first();

        $response1 = $this->actingAs($this->studentUser)->get(route('proposals.edit', $proposal));
        $response1->assertStatus(403);

        $response2 = $this->actingAs($this->supervisorUser)->get(route('proposals.edit', $proposal));
        $response2->assertStatus(403);
    }

    /** @test */
    public function student_or_supervisor_updates_a_proposal(){
        
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $this->supervisorUser = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => "2468013579",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
        ]);

        $this->actingAs($this->studentUser)->post('/proposals', [
            'name' => 'Proposal name',
            'description' => 'Hello World. I am a description which will state the context of what I am conveying',
            'studentID' => $this->studentUser,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        $proposal = Proposal::first();

        $response1 = $this->actingAs($this->studentUser)->patch('/proposals/'.$proposal->id, [
            'name' => 'Updated Proposal',
            'description' => 'Ive UPDATED',
            'studentID' => $this->studentUser->id,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        
        $response1->assertStatus(403);

        $response2 = $this->actingAs($this->supervisorUser)->patch('/proposals/'.$proposal->id, [
            'name' => 'Updated Proposal',
            'description' => 'Ive UPDATED',
            'studentID' => $this->studentUser->id,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        $response2->assertStatus(403);
    }

    // Shown
    public function show_proposal_of_a_student_to_directed_supervisor(){
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $this->supervisorUser = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => "2468013579",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
        ]);

        $this->actingAs($this->studentUser)->post('/proposals', [
            'name' => 'Proposal name',
            'description' => 'Hello World. I am a description which will state the context of what I am conveying',
            'studentID' => $this->studentUser,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());

        $response = $this->get(route('proposals.show', $proposal));

        $response->assertOk();
    }

    /** @test */
    public function a_proposal_can_be_deleted(){
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $this->supervisorUser = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => "2468013579",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
        ]);

        $this->actingAs($this->studentUser)->post('/proposals', [
            'name' => 'Proposal name',
            'description' => 'Hello World. I am a description which will state the context of what I am conveying',
            'studentID' => $this->studentUser,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());

        $response = $this->actingAs($this->studentUser)
            ->delete('/proposals/'.$proposal->id);

        $response->assertStatus(403);
    }

    // Supervisors accepting proposal
    public function supervisor_can_accept_proposal(){
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $this->supervisorUser = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User',
            'username' => "supervisor",
            'email' => "supervisor@fypalloc.com",
            'sun' => "2468013579",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor"),
        ]);

        $this->actingAs($this->studentUser)->post('/proposals', [
            'name' => 'Proposal name',
            'description' => 'Hello World. I am a description which will state the context of what I am conveying',
            'studentID' => $this->studentUser,
            'supervisorID' => $this->supervisorUser->id,
        ]);

        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());

        $this->actingAs($this->supervisor)
            ->decision($proposal);
    }
    // Supervisors rejecting proposal
}
