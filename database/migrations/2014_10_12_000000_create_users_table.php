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
            $table->string('name')->collate('utf8_bin');;
            $table->string('email')->unique()->collate('utf8_bin');;
            $table->string('avatar')->nullable()->collate('utf8_bin');;
            $table->string('password')->collate('utf8_bin');;
            $table->integer('role_id')->unsigned()->default(2);
//            $table->integer('status_id')->unsigned()->default(1);
            $table->boolean('isBlocked')->default(false);
            $table->integer('goal')->default(0);
            $table->string('remember_token')->default(0)->collate('utf8_bin');;
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

