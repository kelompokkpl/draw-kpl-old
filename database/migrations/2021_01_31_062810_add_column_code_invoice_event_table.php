<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCodeInvoiceEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('event', function (Blueprint $table)
        {
             $table->string('code_invoice', 10)->nullable();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('event', 'code_invoice'))
        {
            Schema::table('event', function (Blueprint $table)
            {
                $table->dropColumn('code_invoice');
            });
        }
    }
}
