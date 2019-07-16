<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkMenuModalityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_modality', function (Blueprint $table) {

            $table->foreign('menu_id', 'menu_modality_fk_menus')->references('id')->on('menus');
            $table->foreign('modality_id', 'menu_modality_fk_modalities')->references('id')->on('modalities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_modality', function (Blueprint $table) {

            $table->dropForeign('menu_modality_fk_menus');
            $table->dropForeign('menu_modality_fk_modalities');
        });
    }
}
