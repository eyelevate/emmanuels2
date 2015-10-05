<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNewColumnsToInventoryItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inventory_items', function(Blueprint $table)
		{
			$table->integer('company_id',false,true)->nullable()->after('id');
			$table->integer('owner_id',false,true)->nullable()->after('company_id');
			$table->integer('menu_id',false,true)->nullable()->after('owner_id');
			$table->string('name',50)->nullable()->after('menu_id');
			$table->text('description')->nullable()->after('name');
			$table->decimal('price',11,2)->nullable()->after('description');
			$table->integer('order_number',false,true)->length(3)->nullable()->after('price');
			$table->text('tags')->nullable()->after('order_number');
			$table->tinyInteger('status')->after('tags');
			$table->integer('list_order',false,true)->length(11)->nullable()->after('status');
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
		Schema::table('inventory_items', function(Blueprint $table)
		{
			
		});
	}

}
