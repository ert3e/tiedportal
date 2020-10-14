<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeComponentsMorph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('project_id');
            $table->morphs('componentable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->integer('project_id');
            $table->dropColumn('componentable_id');
            $table->dropColumn('componentable_type');
        });
    }
}
