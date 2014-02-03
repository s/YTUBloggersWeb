<?php

use Illuminate\Database\Migrations\Migration;

class CreateChecksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checks', function($table)
        {
        	$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->unsignedInteger('user_id');			
			$table->timestamp('last_post');

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('checks');
	}

}