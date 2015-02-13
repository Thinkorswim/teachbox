<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table){
			$table->increments('id');

			$table->string('email', 128);
		    $table->string('name', 128);
			$table->string('password', 128);
			$table->string('password_temp', 128);
			$table->string('code', 60);
			$table->text('remember_token')->nullable();
            $table->boolean('active');

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
		Schema::drop('users');
	}

}
