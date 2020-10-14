<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplierMessageQuoteRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->text('supplier_message')->after('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn('supplier_message');
        });
    }
}
