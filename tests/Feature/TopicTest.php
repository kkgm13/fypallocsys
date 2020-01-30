<?php

namespace Tests\Feature;

use App\User;
use App\Topic;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TopicTest extends TestCase
{
    use RefreshDatabase;
    
    protected $adminUser, $studentUser, $supervisorUser;

    /**
     * Test if Topic has been added to the Database System
     * @test
     */
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
        $this->assertDatabaseHas('topics', [
            'name' => 'Topic Name',
            'isMCApprove' => 1,
        ]);
    }
    
    /** 
     * Topic with an Image Document has been added to the Database System
     * @test
     */
    public function a_topic_with_one_image_added(){
        // $this->withoutExceptionHandling();

        Storage::fake('local');

        $this->adminUser = User::create([
            'firstName' => "Admin",
            'lastName' => 'User',
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);
        $fileName = 'imageTest.jpg';

        $file = UploadedFile::fake()->image($fileName);

        $response = $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
            'topicDocuments' => [$file],
        ]);

        $topic = Topic::first();

        $this->assertCount(1, Topic::all());
        $this->assertDatabaseHas('topics', [
            'name' => 'Topic Name',
            'isMCApprove' => 1,
        ]);
        $this->assertDatabaseHas('topic_documents', [
            'topicID' => $topic->id,
            'fileName' => $fileName
        ]);

        // Storage::disk('local')->assertExists($fileName); // Issue with identifying local disk VS actual public disk in testing

        $response->assertRedirect('/topics/'.$topic->id);
    }

    /**
     * Topic with a Topic Document has been added to the Database System
     * @test
     */
    public function a_topic_with_one_document_added(){
        
        // $this->withoutExceptionHandling();

        Storage::fake('local');

        $this->adminUser = User::create([
            'firstName' => "Admin",
            'lastName' => 'User',
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);
        
        $fileName = 'documentTest.pdf';

        $file = UploadedFile::fake()->create($fileName);

        $response = $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
            'topicDocuments' => [$file],
        ]);

        $topic = Topic::first();

        $this->assertCount(1, Topic::all());
        $this->assertDatabaseHas('topics', [
            'name' => 'Topic Name',
            'isMCApprove' => 1,
        ]);
        $this->assertDatabaseHas('topic_documents', [
            'topicID' => $topic->id,
            'fileName' => $fileName
        ]);

        // Storage::disk('local')->assertExists($fileName); // Issue with identifying local disk VS actual public disk in testing

        $response->assertRedirect('/topics/'.$topic->id);
    }

    /** @test */
    public function a_topic_with_multiple_documents_added(){
        
        // $this->withoutExceptionHandling();

        Storage::fake('local');

        $this->adminUser = User::create([
            'firstName' => "Admin",
            'lastName' => 'User',
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);
        
        // Create Array of Files uploaded
        $file = [];
        array_push($file, UploadedFile::fake()->image('imageTest.jpg'));
        array_push($file, UploadedFile::fake()->create('documentTest.pdf'));
        array_push($file, UploadedFile::fake()->image('imageTest.png'));
        array_push($file, UploadedFile::fake()->create('documentTest.docx'));

        $response = $this->actingAs($this->adminUser)->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
            'topicDocuments' => $file,
        ]);

        $topic = Topic::first();

        $this->assertCount(1, Topic::all());
        $this->assertDatabaseHas('topics', [
            'name' => 'Topic Name',
            'isMCApprove' => 1,
        ]);

        $this->assertDatabaseHas('topic_documents', [
            'topicID' => $topic->id,
            'fileName' => 'imageTest.jpg'
        ]);
        $this->assertDatabaseHas('topic_documents', [
            'topicID' => $topic->id,
            'fileName' => 'imageTest.png'
        ]);
        $this->assertDatabaseHas('topic_documents', [
            'topicID' => $topic->id,
            'fileName' => 'documentTest.docx'
        ]);

        // Storage::disk('local')->assertExists($fileName); // Issue with identifying local disk VS actual public disk in testing

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

        $this->assertDatabaseHas('topics', [
            'name' => 'Topic Name',
            'isMCApprove' => 1,
        ]);

        $topic = Topic::first();

        $response = $this->actingAs($this->adminUser)->patch('/topics/'.$topic->id, [
            'name' => 'Updated Name',
            'description' => "Ive UPDATED",
            'supervisorID' => $this->adminUser->id,
            'isMCApprove' => 0,
            'isCBApprove' => 1,
        ]);

        $this->assertDatabaseMissing('topics', [
            'name' => 'Topic Name',
            'isMCApprove' => 1,
        ]);

        $this->assertEquals('Updated Name', Topic::first()->name);
        $this->assertEquals('Ive UPDATED', Topic::first()->description);
        
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
        $this->assertDatabaseMissing('topics', [
            'name' => 'Topic Name',
            'isMCApprove' => 1,
        ]);
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
}
