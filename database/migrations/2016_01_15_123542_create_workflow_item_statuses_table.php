<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowItemStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_item_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workflow_item_id');
            $table->smallInteger('order');
            $table->string('colour', 6);
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
        Schema::drop('workflow_item_statuses');
    }
}
