<?php

use App\Proposal;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proposal::create([
            'name' => "Proposal 1",
            'description' => "This is a proposal",
            'studentID' => 3,
            'supervisorID' => 1,
            'hasRead' => 1,
            'reasoning' => "This is my reasoning to do this proposal",
        ]);

        Proposal::create([
            'name' => "Proposal 2",
            'description' => "This is a proposal",
            'studentID' => 4,
            'supervisorID' => 2,
            'hasRead' => 1,
            'reasoning' => "This is my reasoning to do this proposal",
            'hasRejected' => 0
        ]);

        Proposal::create([
            'name' => "Proposal 3",
            'description' => "This is a proposal",
            'studentID' => 3,
            'supervisorID' => 1,
            'hasRead' => 0,
            'reasoning' => "This is my reasoning to do this proposal",
            'hasRejected' => 1
        ]);

        Proposal::create([
            'name' => "Proposal 4",
            'description' => "This is a proposal",
            'studentID' => 4,
            'supervisorID' => 2,
            'hasRead' => 1,
            'reasoning' => "This is my reasoning to do this proposal",
            'hasRejected' => 0
        ]);

        Proposal::create([
            'name' => "Proposal 5",
            'description' => "This is a proposal",
            'studentID' => 4,
            'supervisorID' => 1,
            'hasRead' => 1,
            'reasoning' => "This is my reasoning to do this proposal",
            'hasRejected' => 1
        ]);

        Proposal::create([
            'name' => "Proposal 6",
            'description' => "This is a proposal",
            'studentID' => 3,
            'supervisorID' => 2,
            'hasRead' => 1,
            'reasoning' => "This is my reasoning to do this proposal",
            'hasRejected' => 1
        ]);
    }
}
