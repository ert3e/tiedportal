<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConversionFieldsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->date('conversion_date')->after('updated_at')->nullable()->default(null);
            $table->integer('conversion_reason_id')->after('customer_id')->default(0);
            $table->enum('status', ['active', 'lost', 'complete']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('conversion_date');
            $table->dropColumn('conversion_reason_id');
            $table->dropColumn('status');
        });
    }
}
