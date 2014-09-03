<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->integer('receiver_id')->unsigned()->nullable()->default(null);
            $table->text('text')->nullable();
			$table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('set null');
		});

        Schema::create('posts_postitems', function(Blueprint $table)
        {
            $table->integer('post_id');
            $table->morphs('post_item');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
        Schema::drop('posts_postitems');
	}

}
