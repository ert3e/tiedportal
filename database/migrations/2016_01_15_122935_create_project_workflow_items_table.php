<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectWorkflowItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_workflow_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('workflow_item_id');
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->integer('workflow_item_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_workflow_items');
    }
}
