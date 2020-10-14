<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPasswordTypeToComponentFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE component_fields CHANGE COLUMN `type` `type` ENUM('text', 'longtext', 'number', 'decimal', 'date', 'time', 'datetime', 'file', 'password')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE component_fields CHANGE COLUMN `type` `type` ENUM('text', 'longtext', 'number', 'decimal', 'date', 'time', 'datetime', 'file')");
    }
}
