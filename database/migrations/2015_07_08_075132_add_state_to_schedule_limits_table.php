<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStateToScheduleLimitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('schedule_limits', function(Blueprint $table)
		{
			//1 = OPEN, 2 = CLOSE 
			$table->boolean('state')->nullable()->after('id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('schedule_limits', function(Blueprint $table)
		{
			
		});
	}

}
