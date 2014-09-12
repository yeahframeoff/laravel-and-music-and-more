<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTrack extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_track', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->integer('imported_track_id')->unsigned();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');

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
        Schema::table('group_track', function(Blueprint $table) {
            $table->dropForeign('group_track_group_id_foreign');
            $table->dropForeign('group_track_imported_track_id_foreign');
        });

		Schema::drop('group_track');
	}

}