<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumGenresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('album_genres', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('album_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            
            $table->foreign('album_id')
                  ->references('id')
                  ->on('albums');
            
            $table->foreign('genre_id')
                  ->references('id')
                  ->on('genres');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('album_genres', function(Blueprint $table)
        {
        	$table->dropForeign('album_genres_album_id_foreign');    
            $table->dropForeign('album_genres_genre_id_foreign');
        });
        
		Schema::drop('album_genres');
	}

}
