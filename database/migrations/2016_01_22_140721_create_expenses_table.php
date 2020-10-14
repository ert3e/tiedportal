<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expense_type_id');
            $table->smallInteger('recurring_period');
            $table->enum('recurring_unit', ['day', 'week', 'month', 'year']);
            $table->double('amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date')->nullable()->default(null);
            $table->string('name');
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
        Schema::drop('expenses');
    }
}
