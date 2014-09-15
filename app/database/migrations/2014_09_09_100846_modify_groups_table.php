<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement('ALTER TABLE groups MODIFY COLUMN avatar VARCHAR(255)');

        Schema::table('groups', function(Blueprint $table)
		{
            $table->integer('genre_id')->unsigned();
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
		Schema::table('groups', function(Blueprint $table)
		{
            $table->dropForeign('groups_genre_id_foreign');
			$table->dropColumn('genre_id');
            DB::statement('ALTER TABLE groups MODIFY COLUMN avatar BLOB');
        });
	}

}
