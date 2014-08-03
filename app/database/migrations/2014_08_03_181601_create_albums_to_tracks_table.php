<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsToTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('albums_to_tracks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('album_id')->unsigned();
            $table->integer('track_id')->unsigned();
            
            $table->foreign('album_id')
                  ->references('id')
                  ->on('albums');
            
            $table->foreign('track_id')
                  ->references('id')
                  ->on('tracks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('albums_to_tracks', function(Blueprint $table) {
        	$table->dropForeign('albums_to_tracks_album_id_foreign');
            $table->dropForeign('albums_to_tracks_track_id_foreign');
        });
        
		Schema::drop('albums_to_tracks');
	}

}
