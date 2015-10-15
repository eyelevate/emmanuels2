<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_rules', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id',false,true)->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('drivers')->nullable();
            $table->text('schedule_time')->nullable();
            $table->text('weekly_schedule')->nullable();
            $table->text('blackout_dates')->nullable();
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
        Schema::drop('schedule_rules');
    }
}
