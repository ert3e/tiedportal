<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTypeIdFieldToCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $platform = Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('type_id', 'category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('category_id', 'type_id');
        });
    }
}
