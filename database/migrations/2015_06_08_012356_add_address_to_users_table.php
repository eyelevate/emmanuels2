<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAddressToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			// $table->string('street',200)->nullable()->after('email');
			// $table->string('city',50)->nullable()->after('street');
			$table->string('state', 50)->nullable()->after('city');
			// $table->string('zipcode', 10)->nullable()->after('state');
			$table->string('unit', 10)->nullable()->after('zipcode');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			
		});
	}

}
