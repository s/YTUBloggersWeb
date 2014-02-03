<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function($table)
        {
        	$table->engine = 'InnoDB';
			$table->string('client_id');			
			$table->bigInteger('rate_limit');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}

}
