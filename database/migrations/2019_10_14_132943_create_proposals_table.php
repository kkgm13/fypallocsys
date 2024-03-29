<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Proposal Title');
            $table->longText('description')->comment('Proposal Description');
            $table->unsignedBigInteger('studentID')->comment('Foreign Key to STUDENT');
            $table->unsignedBigInteger('supervisorID')->comment('Foreign Key to SUPERVISOR');
            $table->longText('prequisites')->nullable()->comment('Prequisites to do this Proposal');
            $table->string('reasoning')->comment('Proposal Reasoning for Supervisor');
            $table->boolean('hasRead')->comment('Boolean: Intended Supervisor has seen this')->default(0);
            $table->boolean('hasRejected')->nullable()->comment('Boolean: Rejected proposal');
            $table->timestamps();

            // Student Relationship
            $table->foreign('studentID')->references('id')->on('users');
            // Supervisor Relationship
            $table->foreign('supervisorID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
