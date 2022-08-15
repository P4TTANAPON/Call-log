<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePh2HardwareItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ph2_hardware_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->softDeletes();
			$table->integer('create_user_id')->unsigned();
			$table->foreign('create_user_id')->references('id')->on('users');
			$table->string('product')->index();
			$table->string('model_part_number')->index();
			$table->string('serial_number')->unique();
			$table->string('install_location');
			$table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ph2_hardware_items');
    }
}
