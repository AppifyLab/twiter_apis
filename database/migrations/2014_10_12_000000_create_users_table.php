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
            $table->id();
            $table->string('first_name', 199);
            $table->string('last_name', 199);
            $table->string('username', 199);
            $table->string('email', 199)->unique();
            $table->string('password', 199)->nullable();
            $table->string('profile_pic', 199)->nullable();
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER']);
            $table->enum('role', ['SUPER_ADMIN', 'ADMIN'])->comment('SUPER_ADMIN, ADMIN');
            $table->enum('status', ['ACTIVE', 'DEACTIVE', 'BANNED'])->comment('ACTIVE, DEACTIVE, BANNED');
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
