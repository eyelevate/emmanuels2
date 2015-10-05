<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWebsitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('websites', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('company_id')->nullable();
			$table->string('title',50)->nullable();
			$table->text('seo')->nullable();
			$table->text('slides')->nullable();
			$table->text('aboutus')->nullable();
			$table->text('menu')->nullable();
			$table->text('order')->nullable();
			$table->text('contactus')->nullable();
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
		Schema::drop('websites');
	}

}
