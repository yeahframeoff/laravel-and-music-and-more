<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('founder_id')->unsigned();
			$table->string('name');
            $table->text('description');
            $table->boolean('active')->default(false);
            $table->binary('avatar');
            
            $table->foreign('founder_id')
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
        Schema::table('groups', function(Blueprint $table) {
        	$table->dropForeign('groups_founder_id_foreign');    
        });
        
		Schema::drop('groups');
	}

}
