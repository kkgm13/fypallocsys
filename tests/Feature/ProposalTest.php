<?php

namespace Tests\Feature;

use App\Mail\ProposalSent;
use App\Proposal;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    protected $studentUser, $supervisorUser;

    /** @test */
    public function a_proposal_is_added(){
        Mail::fake();

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
            'reasoning' => "This is my reason",
        ]);
        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());
        // $this->actingAs($this->supervisorUser)->get(route('proposals.show'));
       // Redirect
        $response->assertRedirect('/proposals/');
    } 

    /** @test */
    public function proposal_sent_to_supervisor(){

        Mail::fake();

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
            'reasoning' => "This is my reason",
        ]);
        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());
        Mail::assertSent(ProposalSent::class, function($mail){return $mail->hasTo('supervisor@fypalloc.com');});
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
            'reasoning' => "This is my reasoning",
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
            'reasoning' => "This is my reasoning"
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

    /** @test */
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
            'reasoning' => "This is my reason",
        ]);

        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());
        $this->assertDatabaseHas('proposals', ['name' => 'Proposal name']);
        $response = $this->actingAs($this->supervisorUser)->get(route('proposals.show', $proposal));
        $response->assertOk();
    }

    /** @test */
    public function proposal_seen_by_another_supervisor(){
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        $this->supervisorUser1 = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User1',
            'username' => "supervisor1",
            'email' => "supervisor1@fypalloc.com",
            'sun' => "2468013579",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor1"),
        ]);
        $this->supervisorUser2 = User::create([
            'firstName' => "Supervisor",
            'lastName' => 'User2',
            'username' => "supervisor2",
            'email' => "supervisor2@fypalloc.com",
            'sun' => "3191842392",
            'role' => "Supervisor",
            'password' => Hash::make("supervisor2"),
        ]);

        $this->actingAs($this->studentUser)->post('/proposals', [
            'name' => 'Proposal name',
            'description' => 'Hello World. I am a description which will state the context of what I am conveying',
            'studentID' => $this->studentUser,
            'supervisorID' => $this->supervisorUser1->id,
            'reasoning' => "This is my reason",
        ]);

        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());
        $this->assertDatabaseHas('proposals', ['name' => 'Proposal name']);
        $response = $this->actingAs($this->supervisorUser2)->get(route('proposals.show', $proposal));
        $response->assertStatus(403);;
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
            'reasoning' => 'This is my reasoning',
        ]);

        $proposal = Proposal::first();

        $this->assertCount(1, Proposal::all());

        $response = $this->actingAs($this->studentUser)
            ->delete('/proposals/'.$proposal->id);

        $response->assertStatus(403);
    }

    // Supervisors accepting proposal
    /** */
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

        $this->actingAs($this->supervisor)->post('/proposal/accept', [
            'proposal' => $proposal,
            'request' => 'accepted',
        ]);
    }

    // Supervisors rejecting proposal
    public function supervisor_can_reject_proposal(){
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

        $this->actingAs($this->supervisor)->post('/proposals/decision', []);
    }
}
