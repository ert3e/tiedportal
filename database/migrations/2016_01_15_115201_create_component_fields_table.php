<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('component_type_id');
            $table->string('name');
            $table->string('description');
            $table->enum('type', ['text', 'longtext', 'number', 'decimal', 'date', 'time', 'datetime']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('component_fields');
    }
}
