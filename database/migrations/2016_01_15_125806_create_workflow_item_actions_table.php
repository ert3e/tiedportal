<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowItemActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_item_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workflow_item_id');
            $table->string('handler');
            $table->text('metadata');
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
        Schema::drop('workflow_item_actions');
    }
}
