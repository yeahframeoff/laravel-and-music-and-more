<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistTrackTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('playlist_track', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('playlist_id')->unsigned();
            $table->integer('imported_track_id')->unsigned();
            $table->integer('track_number')->unsigned();
            
            $table->foreign('playlist_id')
                  ->references('id')
                  ->on('playlists');
            
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
        Schema::table('playlist_track', function(Blueprint $table) {
        	$table->dropForeign('playlist_track_playlist_id_foreign');
            $table->dropForeign('playlist_track_imported_track_id_foreign');
        });
        
	    Schema::drop('playlist_track');
	}

}
