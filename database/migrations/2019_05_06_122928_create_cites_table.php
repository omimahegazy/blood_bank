<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitesTable extends Migration {

	public function up()
	{
		Schema::create('cites', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->integer('governorate_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('cites');
	}
}