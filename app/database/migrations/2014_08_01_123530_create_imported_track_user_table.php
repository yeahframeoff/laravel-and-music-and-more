<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportedTrackUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('imported_track_user', function(Blueprint $table)
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
        Schema::table('imported_track_user', function(Blueprint $table) {
        	$table->dropForeign('imported_track_user_user_id_foreign');
            $table->dropForeign('imported_track_user_imported_track_id_foreign');
        });
        
	    Schema::drop('imported_track_user');
	}

}
