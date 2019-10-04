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
            $table->string('name')->comment('Project Name');
            $table->longText('description')->comment('Project Description');
            $table->unsignedInteger('userID')->comment('Foreign Key to USERS');
            $table->boolean('isMCApprove')->comment('Boolean: CS Multimedia Approved');
            $table->boolean('isCBApprove')->comment('Boolean: CS Business Approved');
            
            $table->timestamps();
            $table->foreign('userID')->references('id')->on('users');
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
