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
            $table->string('first name')->collate('utf8_bin');
            $table->string('flastst name')->collate('utf8_bin');
            $table->string('email')->unique()->collate('utf8_bin');
            $table->string('avatar')->nullable()->collate('utf8_bin');
            $table->string('password')->collate('utf8_bin');

            $table->string('birthday')->nullable()->collate('utf8_bin');
            $table->string('skype')->nullable()->collate('utf8_bin');
            $table->string('phone')->nullable()->collate('utf8_bin');
            $table->string('title')->nullable()->collate('utf8_bin');

            $table->integer('role_id')->unsigned()->default(3);
            $table->integer('location_id')->unsigned()->default(0);
            $table->integer('workstation')->nullable();

            $table->boolean('isBlocked')->default(false);
            $table->integer('goal')->default(0);
            $table->string('remember_token')->default(0)->collate('utf8_bin');
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

