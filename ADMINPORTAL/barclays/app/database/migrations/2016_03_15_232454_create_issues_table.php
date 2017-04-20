<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issues', function(Blueprint $table)
		{
			$table->increments('id');

			$table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

			$table->unsignedInteger('device_id');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('restrict')->onUpdate('cascade');

            $table->unsignedInteger('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('restrict')->onUpdate('cascade');

			$table->string('location');
			$table->text('description')->nullable();
          		
            $table->string('issue');
            $table->string('issue_other')->nullable();
            $table->string('serial_no')->nullable();
            

			$table->text('comments')->nullable();
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
		Schema::drop('issues');
	}

}
