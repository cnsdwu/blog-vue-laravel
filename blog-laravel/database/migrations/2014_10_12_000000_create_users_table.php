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
            $table->increments('id');
            $table->string('username', 100);
            $table->string('email', 100);
            $table->string('password', 255);
            $table->unsignedTinyInteger('permission')->default(0);
            $table->unsignedTinyInteger('active')->default(0);
            $table->unsignedTinyInteger('attempt')->default(0);
            $table->string('nickname',100);
            $table->string('head',200)->nullable(true);
            $table->string('ip',50)->nullable(true);
            $table->string('vcode',50)->nullable(true);
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
