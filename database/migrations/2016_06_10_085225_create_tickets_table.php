<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->integer('project_id');
            $table->smallInteger('severity');
            $table->enum('status', ['pending', 'assigned', 'closed'])->default('pending');
            $table->string('subject');
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
        Schema::drop('tickets');
    }
}
