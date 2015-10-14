<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleOverwritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_overwrites', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id',false,true)->nullable();
            $table->integer('schedule_rules_id',false,true)->nullable();
            $table->dateTime('schedule_date')->nullable();
            $table->tinyInteger('drivers')->nullable();
            $table->integer('schedule_time')->nullable();
            $table->text('weekly_schedule')->nullable();
            $table->text('zipcodes')->nullable();
            $table->tinyInteger('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('schedule_overwrites');
    }
}
