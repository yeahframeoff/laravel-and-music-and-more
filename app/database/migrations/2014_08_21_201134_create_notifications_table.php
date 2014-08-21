<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reffered_user_id')->unsigned();
            $table->integer('notification_type_id')->unsigned();
            $table->morphs('notification_object');
            $table->bool('checked')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('referred_user_id')
                ->references('id')->on('users')->onDelete('nothing');
            $table->foreign('notification_type_id')
                ->references('id')->on('notification_types')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}
