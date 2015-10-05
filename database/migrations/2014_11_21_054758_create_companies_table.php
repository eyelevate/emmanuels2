<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50)->nullable();
			$table->string('street',200)->nullable();
			$table->string('city',50)->nullable();
			$table->string('state', 50)->nullable();
			$table->string('region', 50)->nullable();
			$table->string('country', 50)->nullable();
			$table->string('zipcode', 10)->nullable();
			$table->string('phone', 12)->nullable();
			$table->string('email',200)->nullable();
			$table->text('store_hours')->nullable();
			$table->text('blackout')->nullable();
			$table->tinyInteger('status')->default('0');
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
		Schema::drop('companies');
	}

}
