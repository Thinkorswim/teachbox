<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTests extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tests', function($table){
			$table->increments('id');

			$table->integer('lesson_id');
		    $table->string('question', 256);
			$table->string('choice_1', 256);
			$table->string('choice_2', 256);
			$table->string('choice_3', 256)->nullable();
			$table->string('choice_4', 256)->nullable();
			$table->smallInteger('answer');


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
		Schema::drop('tests');
	}

}
