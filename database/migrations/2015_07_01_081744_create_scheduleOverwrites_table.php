<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScheduleOverwritesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_overwrites', function(Blueprint $table)
		{
			$table->increments('id');
			//SINGLE OR RANGE
			$table->tinyInteger('type');
			//IF SINGLE
			$table->dateTime('overwrite_date')->nullable();
			//IF RANGE
			$table->dateTime('overwrite_date_start')->nullable();
			$table->dateTime('overwrite_date_end')->nullable();
			//FOR BOTH
			$table->dateTime('overwrite_hours_open')->nullable();
			$table->dateTime('overwrite_hours_close')->nullable();
			$table->tinyInteger('number_of_employee')->nullable();

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
		Schema::drop('scheduleOverwrites');
	}

}
