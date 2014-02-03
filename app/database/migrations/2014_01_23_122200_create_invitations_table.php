<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invitations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index();
			$table->integer('event_id')->index();
			$table->integer('confirmed')->default(0)->index();
			$table->integer('cancelled')->default(0)->index();
			$table->integer('sent')->default(0)->index();
			$table->text('note')->nullable();
			$table->string('hash')->index();
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
		Schema::drop('invitations');
	}

}
