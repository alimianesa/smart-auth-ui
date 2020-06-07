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

            // Register Data
            $table->string('country_code');
            $table->bigInteger('phone_number');

            $table->string('password')->nullable();

            // Card
            $table->string('card_number' , 10);
            $table->string("card_serial")->nullable();

            // TimeStamps
            $table->timestamp('phone_number_confirmed_at')->nullable();
            $table->timestamp('card_verified_at')->nullable();
            $table->timestamp('speech_verified_at')->nullable();
            $table->timestamp('video_verified_at')->nullable();
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
