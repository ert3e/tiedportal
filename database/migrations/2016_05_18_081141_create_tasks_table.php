<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->morphs('taskable');
            $table->dateTime('due_date');
            $table->dateTime('start_date');
            $table->integer('task_type_id');
            $table->integer('task_status_id');
            $table->smallInteger('priority');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->boolean('private')->default(false);
            $table->string('title');
            $table->text('description');
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
        Schema::drop('tasks');
    }
}
