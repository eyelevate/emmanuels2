<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_transactions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id',false,true)->nullable();
            $table->integer('customer_id',false,true)->nullable();
            $table->integer('employee_id',false,true)->nullable();
            $table->dateTime('schedule_date')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('suit', 50)->nullable();
            $table->string('street', 125)->nullable();
            $table->integer('zipcode')->nullable();
            $table->decimal('estimate', 11,2)->nullable();
            $table->decimal('due', 11,2)->nullable();
            $table->string('payment_id', 11)->nullable();
            $table->string('card_id', 11)->nullable();
            $table->tinyInteger('status');
            $table->softDeletes();
            $table->timestamps();
            $table->dateTime('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('schedule_transactions');
    }
}
