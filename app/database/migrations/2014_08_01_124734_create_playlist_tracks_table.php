<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('playlist_tracks', function(Blueprint $table)
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
        Schema::table('playlist_tracks', function(Blueprint $table) {
        	$table->dropForeign('playlist_tracks_playlist_id_foreign');
            $table->dropForeign('playlist_tracks_imported_track_id_foreign');
        });
        
	    Schema::drop('playlist_tracks');
	}

}
