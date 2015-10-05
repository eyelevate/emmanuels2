<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('param_one', 25)->nullable();
			$table->string('param_two', 15)->nullable();
			$table->text('title')->nullable();
			$table->text('description')->nullable();
			$table->text('keywords')->nullable();
			$table->string('url', 255)->nullable();
			$table->tinyInteger('content_count')->nullable();
			$table->text('content_data')->nullable();
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
		Schema::drop('pages');
	}

}
