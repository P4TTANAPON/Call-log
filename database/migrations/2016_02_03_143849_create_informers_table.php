<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->string('name')->index();
			$table->string('phone_number', 20)->index();
			$table->enum('type', ['C','I']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('informers');
    }
}
