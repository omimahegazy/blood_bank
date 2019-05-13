<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('phone', 255);
			$table->string('facebook_url', 255);
			$table->string('email', 255);
			$table->string('youtube_url', 255);
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}