<?php

namespace Tests\Feature;

use App\User;
use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function a_topic_is_added(){

        $this->withoutExceptionHandling();

        $response = $this->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => User::find(1),
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $response->assertOk();
        $this->assertCount(1, Topic::all());
    }
    
    /**@test */
    public function a_topic_is_updated(){
        $this->withoutExceptionHandling();

        $this->post('/topics', [
            'name' => 'Topic Name',
            'description' => "Hello World. I am a description which will state the context of what I am conveying",
            'supervisorID' => User::find(1),
            'isMCApprove' => 1,
            'isCBApprove' => 1,
        ]);

        $topic = Topic::first();

        $this->patch('/topics/'.$topic->id, [
            'name' => 'Updated Topic Name',
            'description' => "Hello World. I am an updated description which will state the context of what I am conveying",
            'supervisorID' => User::find(1),
            'isMCApprove' => 0,
            'isCBApprove' => 1,
        ]);
        $this->assertEquals('Updated Topic Name', Topic::first()->title);
        $this->assertEquals('Hello World. I am an updated description which will state the context of what I am conveying', Topic::first()->description);
    }
}
