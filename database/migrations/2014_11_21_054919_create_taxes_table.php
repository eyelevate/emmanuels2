<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('city',50)->nullable();
			$table->string('state',50)->nullable();
			$table->string('country')->nullable();
			$table->string('zipcode')->nullable();
			$table->float('tax_rate',7,4)->nullable();
			$table->tinyInteger('status');
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
		Schema::drop('taxes');
	}

}
