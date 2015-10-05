<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNewColumnsToInventoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inventories', function(Blueprint $table)
		{
			$table->unsignedInteger('owner_id',false)->nullable();
			$table->text('company_id')->nullable();
			$table->string('name',50)->nullable();
			$table->tinyInteger('status');
			$table->integer('list_order',false,true)->length(11)->nullable();
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
		Schema::table('inventories', function(Blueprint $table)
		{
			
		});
	}

}
