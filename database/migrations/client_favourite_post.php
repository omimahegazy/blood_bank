<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCTable extends Migration {

    public function up()
    {
        Schema::create('client_favourite_post', function(Blueprint $table) {

            $table->integer('post_id');
            $table->integer('client_id');
            $table->integer('is_favourite')->unsigned();
        });
    }

    public function down()
    {
        Schema::drop('client_favourite_post');
    }
}