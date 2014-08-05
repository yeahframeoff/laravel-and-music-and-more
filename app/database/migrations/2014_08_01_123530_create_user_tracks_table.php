<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('user_tracks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
            $table->integer('imported_track_id')->unsigned();
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
            
            $table->foreign('imported_track_id')
                  ->references('id')
                  ->on('imported_tracks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('user_tracks', function(Blueprint $table) {
        	$table->dropForeign('user_tracks_user_id_foreign');
            $table->dropForeign('user_tracks_imported_track_id_foreign');
        });
        
	    Schema::drop('user_tracks');
	}

}
