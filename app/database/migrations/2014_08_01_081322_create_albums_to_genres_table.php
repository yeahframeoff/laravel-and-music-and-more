<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsToGenresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('albums_to_genres', function(Blueprint $table)
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
        Schema::table('albums_to_genres', function(Blueprint $table)
        {
        	$table->dropForeign('albums_to_genres_album_id_foreign');    
            $table->dropForeign('albums_to_genres_genre_id_foreign');
        });
        
		Schema::drop('albums_to_genres');
	}

}
