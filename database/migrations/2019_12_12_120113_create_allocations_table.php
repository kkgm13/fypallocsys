<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('studentID')->comment('Foreign key to STUDENT');
            $table->unsignedBigInteger('supervisorID')->comment('Foreign Key to SUPERVISOR');
            $table->unsignedBigInteger('proposalID')->nullable()->comment('Foreign Key to Proposals')->unique();
            $table->unsignedBigInteger('topicID')->nullable()->comment('Foreign Key to Proposals');
            $table->boolean('superAuth')->default(0)->comment('Supervisor Authorized');
            $table->boolean('modAuth')->default(0)->comment('Module Leader Authorized');
            $table->timestamps();

            // Student Relationship
            $table->foreign('studentID')->references('id')->on('users');
            // Supervisors Relationship
            $table->foreign('supervisorID')->references('id')->on('users');
            // Topics Relationship
            $table->foreign('topicID')->references('id')->on('topics');
            // Proposals Relationship
            $table->foreign('proposalID')->references('id')->on('proposals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allocations');
    }
}
