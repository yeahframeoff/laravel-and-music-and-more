<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('artists', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
            $table->integer('genre_id')->unsigned();
            $table->text('bio');
            
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
        Schema::table('artists', function(Blueprint $table)
        {
        	$table->dropForeign('artists_genre_id_foreign');
        });
        
		Schema::drop('artists');
	}

}
