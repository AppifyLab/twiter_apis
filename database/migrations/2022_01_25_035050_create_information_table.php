<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('action', 199);
            $table->string('challenge', 199);
            $table->mediumText('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('food_type', 199)->nullable();
            $table->text('description')->nullable();
            $table->string('website', 199)->nullable();
            $table->string('star_rating', 199)->nullable();
            $table->string('google_ratings', 199)->nullable();
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
        Schema::dropIfExists('information');
    }
}
