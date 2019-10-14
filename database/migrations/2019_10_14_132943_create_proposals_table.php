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
            $table->unsignedInteger('studentID')->comment('Foreign Key to STUDENT');
            $table->unsignedInteger('supervisorID')->comment('Foreign Key to SUPERVISOR');
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
