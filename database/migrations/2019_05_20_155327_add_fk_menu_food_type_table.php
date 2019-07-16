<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkMenuFoodTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_food_type', function (Blueprint $table) {

            $table->foreign('menu_id', 'menu_food_type_fk_menus')->references('id')->on('menus');
            $table->foreign('foodType_id', 'menu_food_type_fk_foodTypes')->references('id')->on('food_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_food_type', function (Blueprint $table) {

            $table->dropForeign('menu_food_type_fk_menus');
            $table->dropForeign('menu_food_type_fk_foodTypes');
        });
    }
}
