<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('event_id')->index();
			$table->integer('player1_id')->index();
			$table->integer('player2_id')->index();
			$table->integer('player1_score')->default(0);
			$table->integer('player2_score')->default(0);
			$table->integer('winner_id')->index();
			$table->text('description')->nullable();
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
		Schema::drop('matches');
	}

}
