<?php

use App\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Topic::create([
            'name' => "Topic Name 1",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati deleniti iure quos? Mollitia corrupti fuga rerum rem magni, assumenda temporibus ipsum?", 
            'studentID' => null,
            'supervisorID' => 1,
            'prequisites' => "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
            "corequisites" => "N/A",
            "isMCApprove" => 1,
            "isCBApprove" => 0,
        ]);

    }
}
