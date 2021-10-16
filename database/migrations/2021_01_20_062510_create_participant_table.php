<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('participant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('event_id')->length(20)->unsigned();
            $table->foreign('event_id')->references('id')->on('event')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('participant_id', 30);
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 16);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant');
    }
}
