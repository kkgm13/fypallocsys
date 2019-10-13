<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    /**
     * @test
     */
    public function a_topic_is_added(){
        $this->withoutExceptionHandling();
        $response = $this->post('/topics', [
            'name' => 'Topic Name',
            'supervisorID' => App\User::find(1),
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
    }
}
