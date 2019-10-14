<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Aston User\'s Name');
            $table->string('username')->comment('Aston User\'s username');
            $table->string('email')->unique()->comment('Aston User\'s Email Address');
            $table->string('sun')->unique()->comment('Aston Student Unique Number');
            $table->string('programme')->nullable()->comment('Aston Student Programme');
            $table->enum('role', ['Student', 'Supervisor', 'Module Leader', 'Admin'])->comment('Roles Mechanisms')->default('Student');
            $table->integer('maxProject')->comment('Maximum Project Selection')->default(0); // Limit via Saving and merging
            // $table->timestamp('email_verified_at')->nullable(); // Not needed
            $table->string('password'); // Check with getting the UNIVERSITY DETAILS
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
