<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chat_messages', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('chat_id')->unsigned();
			$table->integer('from_user_id')->unsigned();
            $table->text('message');
            $table->timestamps();
            
            $table->foreign('from_user_id')
                  ->references('id')
                  ->on('users');
            
            $table->foreign('chat_id')
                  ->references('id')
                  ->on('chats');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('chat_messages', function(Blueprint $table) {
            $table->dropForeign('chat_messages_from_user_id_foreign');
            $table->dropForeign('chat_messages_chat_id_foreign');
        });

		Schema::drop('chat_messages');
	}

}
