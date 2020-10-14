<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeProjectDateFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `projects` MODIFY `start_date` DATE NULL;');
        DB::statement('ALTER TABLE `projects` MODIFY `due_date` DATE NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `projects` MODIFY `start_date` DATE NOT NULL;');
        DB::statement('ALTER TABLE `projects` MODIFY `due_date` DATE NOT NULL;');
    }
}
