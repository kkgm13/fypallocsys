<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('topicID')->comment('Foreign Key to TOPICS');
            $table->string('fileName')->comment('File Name');
            $table->timestamps();

            $table->foreign('topicID')->references('id')->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_documents');
    }
}
