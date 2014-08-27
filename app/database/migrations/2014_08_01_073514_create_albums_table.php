<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('albums', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('artist_id')->unsigned();
            $table->string('name');
            $table->string('artwork');
			$table->date('release_date');
            
            $table->foreign('artist_id')
                  ->references('id')
                  ->on('artists');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('albums', function(Blueprint $table)
        {
        	$table->dropForeign('albums_artist_id_foreign');
        });
        
		Schema::drop('albums');
	}

}
