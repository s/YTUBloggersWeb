<?php

use Illuminate\Database\Migrations\Migration;

class CreateDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data', function($table)
        {
        	$table->engine = 'InnoDB';
			$table->increments('id');
			$table->unsignedInteger('user_id');			
			$table->string('post_url', 100);
			$table->text('post_content');
			$table->timestamp('post_created_at');
			$table->foreign('user_id')->references('id')->on('blogs')->onDelete('cascade');
        });	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('data');
	}

}
