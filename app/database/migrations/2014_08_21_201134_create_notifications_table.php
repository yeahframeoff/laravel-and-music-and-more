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
            $table->string('type', 30);
            $table->morphs('object');
            $table->boolean('checked')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->foreign('reffered_user_id')
                ->references('id')->on('users');
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
