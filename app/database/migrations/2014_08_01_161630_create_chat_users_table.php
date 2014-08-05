<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chat_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('chat_id')->unsigned();
            $table->integer('user_id')->unsigned();
            
            $table->foreign('chat_id')
                  ->references('id')
                  ->on('chats');
            
            $table->foreign('user_id')
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
        Schema::table('chat_users', function(Blueprint $table) {
        	$table->dropForeign('chat_users_user_id_foreign');
            $table->dropForeign('chat_users_chat_id_foreign');
        });
        
		Schema::drop('chat_users');
	}

}
