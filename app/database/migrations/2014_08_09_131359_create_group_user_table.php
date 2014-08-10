<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
            
            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('group_user', function(Blueprint $table) {
            $table->dropForeign('group_user_user_id_foreign');
            $table->dropForeign('group_user_group_id_foreign');
        });
        
		Schema::drop('group_user');
	}

}
