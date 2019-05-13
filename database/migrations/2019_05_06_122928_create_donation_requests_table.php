<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationRequestsTable extends Migration {

	public function up()
	{
		Schema::create('donation_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->date('last_donation');
			$table->string('name', 255);
			$table->string('address', 255);
			$table->string('phone', 255);
			$table->integer('blood_type_id');
			$table->string('hospital_name', 255);
			$table->integer('patient_age');
			$table->integer('required_amount');
            $table->string('details', 255);
		});
	}

	public function down()
	{
		Schema::drop('donation_requests');
	}
}