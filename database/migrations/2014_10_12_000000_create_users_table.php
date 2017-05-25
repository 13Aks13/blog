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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('password');

            $table->string('birthday')->nullable();
            $table->string('skype')->nullable();
            $table->string('phone')->nullable();
            $table->string('title')->nullable();

            $table->integer('role_id')->unsigned()->default(3);
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('workstation')->nullable();

            $table->boolean('isBlocked')->default(false);
            $table->integer('goal')->default(0);
            $table->string('remember_token')->default(0);
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

