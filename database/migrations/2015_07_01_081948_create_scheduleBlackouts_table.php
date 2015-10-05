<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScheduleBlackoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_blackouts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->dateTime('blackout_date')->nullable();
			$table->text('description')->nullable();
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
		Schema::drop('scheduleBlackouts');
	}

}
