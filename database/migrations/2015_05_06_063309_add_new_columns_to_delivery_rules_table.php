<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNewColumnsToDeliveryRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('delivery_rules', function(Blueprint $table)
		{
			$table->unsignedInteger('company_id', false)->nullable();
			$table->boolean('pickup')->nullable();
			$table->boolean('dropoff')->nullable();
			$table->integer('pickup_limit',false,true)->nullable();
			$table->text('pickup_limit_inc')->nullable();
			$table->text('dropoff_tat')->nullable();
			$table->integer('dropoff_limit',false,true)->nullable();
			$table->text('dropoff_limit_inc')->nullable();
			$table->text('delivery_ranges')->nullable();
			$table->text('delivery_schedules')->nullable();
			$table->text('blackout_dates')->nullable();
			$table->text('requested_range')->nullable();
			$table->boolean('pay_start')->nullable();
			$table->boolean('pay_end')->nullable();
			$table->tinyInteger('status');
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('delivery_rules', function(Blueprint $table)
		{
			
		});
	}

}
