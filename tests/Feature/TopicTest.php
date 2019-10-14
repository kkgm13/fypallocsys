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
            'supervisorID' => User::find(1),
        ]);

        $response->assertOk();
        $this->assertCount(1, Topic::all());
    }
}
