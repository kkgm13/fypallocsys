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
    
    protected $adminUser;

    /**
     * @test
     * The 
     */
    public function a_topic_is_added(){

        $this->withoutExceptionHandling();

        $this->adminUser = User::create([
            'name' => "Admin User",
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        $response = $this->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();

        $this->assertCount(1, Topic::all());
        // $response->assertRedirect('/topics/'.$topic->id);
        $response->assertRedirect('/topics/');

    }
    
    /**
     * @test
     */
    public function a_topic_is_updated(){

        $this->withoutExceptionHandling();

        $this->adminUser = User::create([
            'name' => "Admin User",
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        $this->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();

        $response = $this->patch('/topics/'.$topic->id, [
            'name' => 'Updated Name',
            'description' => "Ive UPDATED",
            'supervisorID' => $this->adminUser,
            'isMCApprove' => 0,
            'isCBApprove' => 1,
        ]);

        $this->assertEquals('Updated Name', Topic::first()->name);
        $this->assertEquals('Ive UPDATED', Topic::first()->description);
        // $response->assertRedirect('/topics/'.$topic->id);
        $response->assertRedirect('/topics/');
    }

    /**
     * @test
     * */
    public function a_topic_is_deleted(){

        $this->withoutExceptionHandling();
        
        $this->adminUser = User::create([
            'name' => "Admin User",
            'username' => "admin",
            'email' => "email@fypalloc.com",
            'sun' => "123456789",
            'role' => "Module Leader",
            'password' => Hash::make("admin"),
        ]);

        $this->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => $this->adminUser,
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();
        $this->assertCount(1, Topic::all());

        $response = $this->delete('/topics/'.$topic->id);

        $this->assertCount(0, Topic::all());
        $response->assertRedirect('/topics/');
    }
}
