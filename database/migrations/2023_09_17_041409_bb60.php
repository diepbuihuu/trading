<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Bb60 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bb60', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('time')->index();
            $table->decimal('sma', 8, 2);
            $table->decimal('sd', 8, 2);
            $table->decimal('upper', 8, 2);
            $table->decimal('lower', 8, 2);
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
        Schema::dropIfExists('bb60');
    }
}
