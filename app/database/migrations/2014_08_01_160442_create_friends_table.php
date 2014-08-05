<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('friends', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('friend_id')->unsigned();
			$table->timestamps();
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
            
            $table->foreign('friend_id')
                  ->references('id')
                  ->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('friends', function(Blueprint $table) {
        	$table->dropForeign('friends_user_id_foreign');
            $table->dropForeign('friends_friend_id_foreign');
        });
        
	    Schema::drop('friends');
	}

}
