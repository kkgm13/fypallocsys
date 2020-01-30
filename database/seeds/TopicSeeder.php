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
        Topic::create([
            'name' => "Topic Name 2",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia corrupti fuga rerum rem magni, assumenda temporibus ipsum?", 
            'studentID' => null,
            'supervisorID' => 2,
            'prequisites' => "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
            "corequisites" => "N/A",
            "isMCApprove" => 0,
            "isCBApprove" => 0,
        ]);
        Topic::create([
            'name' => "Topic Name 3",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit, obcaecati deleniti iure quos? Mollitia corrupti fuga rerum rem magni?", 
            'studentID' => null,
            'supervisorID' => 2,
            'prequisites' => "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
            "corequisites" => "CS3250",
            "isMCApprove" => 1,
            "isCBApprove" => 0,
        ]);
        Topic::create([
            'name' => "Topic Name 4",
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elitMollitia corrupti fuga rerum rem magni, assumenda temporibus ipsum?", 
            'studentID' => null,
            'supervisorID' => 1,
            'prequisites' => "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
            "corequisites" => "CS3040",
            "isMCApprove" => 0,
            "isCBApprove" => 1,
        ]);

    }
}
