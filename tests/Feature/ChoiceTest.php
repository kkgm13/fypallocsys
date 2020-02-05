<?php

namespace Tests\Feature;

use App\Allocation;
use App\Choice;
use App\Topic;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChoiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected $adminUser, $studentUser;

    /** @test */
    public function student_selects_a_topic(){

        // Create Admin User
        $this->adminUser = User::create([
            'firstName' => "New Admin",
            'lastName' => 'User',
            'username' => "newadmin",
            'email' => "newemail@fypalloc.com",
            'sun' => "5647382910",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        // Create a student
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        // Post Recording acting as the Module Leader
        $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();

        // Need to understand logoic of how it takes Topic Info in this as it makes absolute no sense in the Test
        $response = $this->actingAs($this->studentUser)->post('/topics/'.$topic->id.'/select', [
            // 'topic' => $topic,
            'studentID' => $this->studentUser->id,
            'pitching' => null,
        ]);

        $this->assertCount(1, Choice::all());
        $response->assertRedirect('/topics/'.$topic->id);
        $this->assertDatabaseHas('choices', [
            'topicID' => $topic->id,
            'studentID' => $this->studentUser->id,

        ]);

    }

    /** */
    public function student_deselects_a_topic(){
        // Create Admin User
        $this->adminUser = User::create([
            'firstName' => "New Admin",
            'lastName' => 'User',
            'username' => "newadmin",
            'email' => "newemail@fypalloc.com",
            'sun' => "5647382910",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        // Create a student
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

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

        $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();
        $this->assertCount(1, Topic::all());

        // Create Choice Selection
        $this->actingAs($this->studentUser)->post('/topics/'.$topic->id.'/select', [
            // 'topic' => $topic,
            'studentID' => $this->studentUser->id,
            'pitching' => null,
        ]);

        $this->assertCount(1, Choice::all());
        $this->assertDatabaseHas('choices', [
            'topicID' => $topic->id,
            'studentID' => $this->studentUser->id,
        ]);
    }

    /** @test */
    public function student_selects_topic_with_topic_allocation(){
        $this->withoutExceptionHandling();
        // Create Admin User
        $this->adminUser = User::create([
            'firstName' => "New Admin",
            'lastName' => 'User',
            'username' => "newadmin",
            'email' => "newemail@fypalloc.com",
            'sun' => "5647382910",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        // Create a student
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => "User",
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

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

        // Post Recording acting as the Module Leader
        $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 0,
            'isCBApprove' => 1,
        ]);

        $first = Topic::first();
        $this->assertCount(1, Topic::all());

         // Post Recording acting as the Supervisor
        $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name 2',
            'description' => "Hello World. I am another description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 0,
        ]);
        $this->assertCount(2, Topic::all());

        $second = Topic::where('name', 'Topic Name 2')->get();

        // dd($second);

        $alloc = Allocation::create([
            'studentID' => $this->studentUser->id,
            'supervisorID' => $this->adminUser->id,
            'proposalID' => null,
            'topicID' => $first->id,
            'superAuth' => 1,
            'modAuth' => 0,
        ]);
        $alloc->assertCreated();
        $this->assertCount(1, Allocation::all());

        $response = $this->actingAs($this->studentUser)->post('/topics/'.$second->id.'/select', [
            // 'topic' => $topic,
            'studentID' => $this->studentUser->id,
            'pitching' => null,
        ]);

        $response->assertSeeText('');
    }
}
