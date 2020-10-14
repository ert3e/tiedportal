<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workflow_id');
            $table->integer('media_id');
            $table->enum('type', ['step', 'action']);
            $table->string('name');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('workflow_items');
    }
}
