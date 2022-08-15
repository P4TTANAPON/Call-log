<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sat_survey', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->softDeletes();
            $table->ipAddress('visitor');
            $table->enum('created_user', ['CC','ANONYMOUS']);
            $table->integer('job_id')->unsigned();
            $table->string('ticket_no');
            $table->enum('q1', ['1','2','3','4','5']);
            $table->string('q2');
            $table->enum('q3', ['1','2','3','4','5','6','7','8','9','10']);
            $table->string('q4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sat_survey');
    }
}
