<?php

namespace Tests\Feature;

use App\User;
use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;
    
    protected $adminUser, $studentUser, $supervisorUser;

    /** @test */
    public function a_topic_is_added(){

        // $this->withoutExceptionHandling();

        $this->adminUser = User::create([
            'firstName' => "Admin",
            'lastName' => 'User',
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        $response = $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();

        $this->assertCount(1, Topic::all());
        $response->assertRedirect('/topics/'.$topic->id);

    }
    
    /**
     * @test
     */
    public function a_topic_is_updated(){

        // $this->withoutExceptionHandling();

        $this->adminUser = User::create([
            'firstName' => "Admin",
            'lastName' => 'User',
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();

        $response = $this->actingAs($this->adminUser)->patch('/topics/'.$topic->id, [
            'name' => 'Updated Name',
            'description' => "Ive UPDATED",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 0,
            'isCBApprove' => 1,
        ]);

        $this->assertEquals('Updated Name', Topic::first()->name);
        $this->assertEquals('Ive UPDATED', Topic::first()->description);
        // $response->assertRedirect('/topics/'.$topic->id);
        $response->assertRedirect('/topics/'.$topic->id);
    }

    /**
     * @test
     * */
    public function a_topic_is_deleted(){

        // $this->withoutExceptionHandling();
        
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

        // Post Recording acting as the Module Leader
        $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();
        $this->assertCount(1, Topic::all());

        // Act as the Module leader and...
        $response = $this->actingAs($this->adminUser)
            // Delete Topic
            ->delete('/topics/'.$topic->id);
        
        // Assert 
        $this->assertCount(0, Topic::all());
        $response->assertRedirect('/topics/');
    }

    /** @test */
    public function create_page_is_accessed_by_students(){

        // Create a student
        $this->studentUser = User::create([
            'firstName' => "Student",
            'lastName' => 'User',
            'username' => "student",
            'email' => "student@fypalloc.com",
            'sun' => "987654321",
            'role' => "Student",
            'password' => Hash::make("student"),
        ]);

        // Visit the Topic Creation Page as a student
        $response = $this->actingAs($this->studentUser)
            ->get('/topics/create');
        // Assert the Response Code
        $response->assertStatus(403);
    }

    /** @test */
    public function edit_page_is_accessed_by_students(){

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

        // Visit the Topic Creation Page as a student
        $response = $this->actingAs($this->studentUser)
            ->get(route('topics.create'));
        // Assert the Response Code
        $response->assertStatus(403);
    }

    /** @test */
    public function other_supervisor_attempt_to_edit_another_supervisor_topic(){
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
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();

        // Visit the Topic Creation Page as a student
        $response = $this->actingAs($this->supervisorUser)
            ->get(route('topics.edit', $topic));
        // Assert the Response Code
        $response->assertStatus(403);
    }

    /** @test */
    public function public_can_view_topics_create_page(){
        $response = $this->get(route('topics.create'));
        $response->assertRedirect('/login');
    }

    /**  */
    public function student_selecting_topic(){

    }

    /** */
    public function student_submitting_selected_topics(){
        
    }
}
