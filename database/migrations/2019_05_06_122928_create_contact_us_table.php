<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactUsTable extends Migration {

	public function up()
	{
		Schema::create('contact_us', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('email', 255);
			$table->integer('client_id')->unsigned();
			$table->text('message');
		});
	}

	public function down()
	{
		Schema::drop('contact_us');
	}
}