<?php

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
            $table->integer('media_id');
            $table->integer('company_id');
            $table->integer('user_type_id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('telephone', 20);
            $table->string('mobile', 20);
            $table->dateTime('last_login');
            $table->string('password', 60);
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
        Schema::drop('users');
    }
}
