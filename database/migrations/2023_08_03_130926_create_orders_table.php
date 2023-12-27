<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('strategy_id');
            $table->string('direction');
            $table->integer('open_time')->default(0);
            $table->integer('close_time')->default(0);
            $table->decimal('open_price', 8, 2)->default(0);
            $table->decimal('stop_loss', 8, 2)->default(0);
            $table->decimal('take_profit', 8, 2)->default(0);
            $table->decimal('close_price', 8, 2)->default(0);
            $table->decimal('profit', 8, 2)->default(0);
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
        Schema::dropIfExists('orders');
    }
}
