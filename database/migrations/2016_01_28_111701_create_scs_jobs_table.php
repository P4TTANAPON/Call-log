<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScsJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scs_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->softDeletes();
			$table->integer('create_user_id')->unsigned();
			$table->foreign('create_user_id')->references('id')->on('users');
			$table->integer('job_id')->unsigned();
			$table->foreign('job_id')->references('id')->on('jobs');
			$table->string('serial_number')->index();
			$table->string('product');
			$table->string('model_part_number');
			$table->text('malfunction');
			$table->text('cause')->nullable();
			$table->text('action')->nullable();
			$table->text('remark')->nullable();
			$table->integer('hw_ph1_id')->unsigned()->nullable();
			$table->integer('hw_ph2_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scs_jobs');
    }
}
