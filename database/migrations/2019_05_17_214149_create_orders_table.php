<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('diner_name');
            $table->string('hour');
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->date('date');
            $table->string('amount_people')->nullable();
            $table->string('ingredients')->nullable();
            $table->string('utensils')->nullable();
            $table->string('additional_comments')->nullable();
            $table->string('final_comment')->nullable();
            $table->string('qualification')->nullable();

            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('diner_id')->nullable();

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
