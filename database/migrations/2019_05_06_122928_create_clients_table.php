<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->string('phone', 255);
			$table->string('email', 255);
			$table->date('date_of_birth');
			$table->string('password', 255);
			$table->boolean('is_active');
			$table->date('last_donation');
			$table->integer('city_id')->unsigned();
			$table->integer('blood_type_id')->unsigned();

            $table->string( 'api_token', 60)->unique()->nullable();

		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}