<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEventIdLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('log', function (Blueprint $table)
        {
            $table->bigInteger('event_id')->length(20)->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('event')
                ->onUpdate('cascade')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('log', 'event_id'))
        {
            Schema::table('log', function (Blueprint $table)
            {
                $table->dropColumn('event_id');
            });
        }
    }
}
