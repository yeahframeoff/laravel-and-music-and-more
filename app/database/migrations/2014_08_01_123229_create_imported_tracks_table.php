<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportedTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imported_tracks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('track_id')->unsigned();
            $table->integer('social_id')->unsigned();
            $table->string('track_url');
            
            $table->foreign('track_id')
                  ->references('id')
                  ->on('tracks');
            
            $table->foreign('social_id')
                  ->references('id')
                  ->on('socials');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('imported_tracks', function(Blueprint $table) {
        	$table->dropForeign('imported_tracks_track_id_foreign');
            $table->dropForeign('imported_tracks_social_id_foreign');
        });
        
		Schema::drop('imported_tracks');
	}

}
