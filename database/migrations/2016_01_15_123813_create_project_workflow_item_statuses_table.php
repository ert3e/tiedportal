<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectWorkflowItemStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_workflow_item_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_workflow_item_id');
            $table->integer('project_item_status_id');
            $table->integer('user_id');
            $table->integer('note_id');
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
        Schema::drop('project_workflow_item_statuses');
    }
}
