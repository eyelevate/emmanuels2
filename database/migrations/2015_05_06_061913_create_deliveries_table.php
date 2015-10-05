<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deliveries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('user_id', false)->nullable();
			$table->unsignedInteger('company_id', false)->nullable();
			$table->unsignedInteger('invoice_id', false)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('firstname', 25)->nullable();
			$table->string('lastname', 25)->nullable();
			$table->string('phone', 15)->nullable();
			$table->string('street',200)->nullable();
			$table->string('unit', 10)->nullable();
			$table->string('city',50)->nullable();
			$table->string('state', 50)->nullable();
			$table->string('region', 50)->nullable();
			$table->string('country', 50)->nullable();
			$table->string('zipcode', 10)->nullable();
			$table->tinyInteger('payment_option')->nullable();
			$table->dateTime('pickup_start')->nullable();
			$table->dateTime('pickup_end')->nullable();
			$table->dateTime('dropoff_start')->nullable();
			$table->dateTime('dropoff_end')->nullable();
			$table->dateTime('completed_on')->nullable();
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
		Schema::drop('deliveries');
	}

}
