<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('event_id')->length(20)->unsigned();
            $table->foreign('event_id')->references('id')->on('event')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 100);
            $table->date('transfer_date');
            $table->double('nominal')->length(20)->unsigned();
            $table->string('photo', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
