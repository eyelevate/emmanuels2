<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScheduleLimitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_limits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->dateTime('schedule_hours_open')->nullable();
			$table->dateTime('schedule_hours_close')->nullable();
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
		Schema::drop('scheduleLimits');
	}

}
