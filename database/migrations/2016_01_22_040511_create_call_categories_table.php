<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->softDeletes();
			$table->integer('create_user_id')->unsigned();
			$table->foreign('create_user_id')->references('id')->on('users');
			$table->string('code', 3)->index();
			$table->string('service_type')->index();
			$table->string('problem_group')->index();
			$table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('call_categories');
    }
}
