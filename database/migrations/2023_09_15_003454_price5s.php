<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Price5s extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price5s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('time')->index();
            $table->decimal('open', 8, 2);
            $table->decimal('close', 8, 2);
            $table->decimal('high', 8, 2);
            $table->decimal('low', 8, 2);
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
        Schema::dropIfExists('price5s');
    }
}
