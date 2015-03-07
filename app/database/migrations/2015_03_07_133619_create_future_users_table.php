<?php

use Illuminate\Database\Migrations\Migration;

class CreateFutureUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('future_users', function($table)
		{
			$table->increments('id');
			$table->string('email', 128);

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
		Schema::drop('future_users');
	}

}
