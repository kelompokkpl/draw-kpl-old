<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('event', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('cms_users_id')->length(10)->unsigned();
            $table->foreign('cms_users_id')->references('id')->on('cms_users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 100);
            $table->date('date_start');
            $table->date('date_end');
            $table->string('payment_status', 30);
            $table->string('status', 30);
            $table->string('global_text_color', 100)->nullable();
            $table->string('hr_color', 100)->nullable();
            $table->string('button_background_color', 100)->nullable();
            $table->string('button_text_color', 100)->nullable();
            $table->string('button_border_color', 100)->nullable();
            $table->string('button_shadow_color', 100)->nullable();
            $table->string('button_image', 100)->nullable();
            $table->string('background_new_draw', 100)->nullable();
            $table->string('background_recent_draw', 100)->nullable();
            $table->string('background_draw_history', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event');
    }
}
