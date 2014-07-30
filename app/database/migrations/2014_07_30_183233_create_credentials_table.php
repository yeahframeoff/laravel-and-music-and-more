<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredentialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credentials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
            $table->integer('social_id');
            $table->string('external_id');
            $table->string('token');
            
            $table->foreign('user_id')
      			  ->references('id')->on('users')
      			  ->onDelete('cascade');
            
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
        Schema::table('credentials', function(Blueprint $table)
        {
        	$table->dropForeign('credentials_user_id_foreign');    
            $table->dropForeign('credentials_social_id_foreign');
        });
        
		Schema::drop('credentials');
	}

}
