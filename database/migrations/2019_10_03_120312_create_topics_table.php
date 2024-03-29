<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Project Name')->unique();
            $table->longText('description')->comment('Project Description');
            $table->unsignedBigInteger('studentID')->comment('Foreign Key for STUDENTS')->nullable();
            $table->unsignedBigInteger('supervisorID')->comment('Foreign Key for SUPERVISORS');
            $table->longText('prequisites')->comment('Topic Prequisites')->nullable();
            $table->longText('corequisites')->comment('Topic Corequisites for the year')->nullable();
            $table->boolean('isMCApprove')->comment('Boolean: CS Multimedia Approved')->default(0);
            $table->boolean('isCBApprove')->comment('Boolean: CS Business Approved')->default(0);
            $table->unsignedBigInteger('secondAssessID')->comment('Foreign Key for ASSESSOR SUPERVISORS')->nullable();
            $table->timestamps();

            // Student Relationship
            $table->foreign('studentID')->references('id')->on('users');
            // Supervisor Relationship
            $table->foreign('supervisorID')->references('id')->on('users');
            // Second Assessor Information
            $table->foreign('secondAssessID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
