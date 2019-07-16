<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('birth_date');
            $table->string('email')->unique();
            $table->integer('calification')->default(4);
            $table->string('address');
            $table->string('description')->nullable();
            $table->string('phone');
            $table->string('city');
            $table->integer('age_experience')->nullable();
            $table->string('photo_home')->nullable();
            $table->string('photo_perfil');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->unsignedBigInteger('role_id');

            $table->string('api_token', 60)->unique()->nullable();

            $table->string('FMCToken'); //para token te telefono en firebase

            $table->rememberToken();
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
