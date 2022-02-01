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
            $table->string('username', 199);
            $table->string('email', 199)->unique();
            $table->string('password', 199)->nullable();
            $table->integer('is_ins_scheduled', 1)->nullable()->default(0);
            $table->integer('is_connected', 1)->nullable()->default(0);
            $table->longText('fb_token', 1)->nullable()->default(0);
            
            
            
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
