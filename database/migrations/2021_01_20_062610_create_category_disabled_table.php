<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryDisabledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('category_disabled', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('category_id')->length(20)->unsigned();
            $table->foreign('category_id')->references('id')->on('category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('participant_id')->length(20)->unsigned();
            $table->foreign('participant_id')->references('id')->on('participant')
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
        Schema::dropIfExists('category_disabled');
    }
}
