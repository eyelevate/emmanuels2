<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('company_id',false,true)->nullable();
			$table->float('rate',7,4)->nullable();
			$table->dateTime('time')->nullable();
			$table->tinyInteger('type')->nullable();
			$table->string('name',50)->nullable();
			$table->text('description')->nullable();
			$table->dateTime('start')->nullable();
			$table->dateTime('end')->nullable();
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
		Schema::drop('services');
	}

}
