<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLeadsToProspectsOnProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE projects CHANGE COLUMN status status ENUM('prospect', 'active', 'lost', 'complete')");

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->integer('prospect_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE projects CHANGE COLUMN status status ENUM('active', 'lost', 'complete')");

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('type', ['lead', 'project']);
            $table->dropColumn('prospect_status_id');
        });
    }
}
