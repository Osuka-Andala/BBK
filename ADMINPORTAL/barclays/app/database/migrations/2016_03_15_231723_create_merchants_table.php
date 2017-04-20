<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('description')->nullable();

			$table->unsignedInteger('county_id');
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('restrict')->onUpdate('cascade');          		
            $table->string('town');
            $table->string('location')->nullable();
            $table->string('manager');
            $table->string('telephone');

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
		Schema::drop('merchants');
	}

}
