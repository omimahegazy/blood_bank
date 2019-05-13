<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->string('image', 255);
			$table->string('body', 255);
			$table->integer('client_id')->unsigned();
			$table->integer('category_id')->unsigned();

		});
	}

	public function down()
	{
		Schema::drop('posts');
	}
}