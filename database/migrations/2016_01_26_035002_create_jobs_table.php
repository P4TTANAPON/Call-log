<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->softDeletes();
			$table->integer('create_user_id')->unsigned();
			$table->foreign('create_user_id')->references('id')->on('users');
			$table->string('ticket_no')->unique();
			$table->integer('department_id')->unsigned();
			$table->foreign('department_id')->references('id')->on('departments');
			$table->string('informer_name')->index();
			$table->string('informer_phone_number', 20)->index();
			$table->enum('informer_type', ['C','I'])->index();
			$table->string('sw_version')->nullable();
			$table->text('description');
			$table->integer('call_category_id')->unsigned()->nullable();
			$table->foreign('call_category_id')->references('id')->on('call_categories');
			$table->integer('primary_system_id')->unsigned()->nullable();
			$table->foreign('primary_system_id')->references('id')->on('systems');
			$table->integer('secondary_system_id')->unsigned()->nullable();
			$table->foreign('secondary_system_id')->references('id')->on('systems');
			$table->boolean('closed')->default('0')->index();
			$table->dateTime('closed_at')->nullable();
			$table->text('remark')->nullable();
			
			$table->enum('last_operator_team', ['CC','SP','SA','NW','ST','SCS'])->nullable();
			$table->integer('last_operator_id')->unsigned()->nullable();
			$table->foreign('last_operator_id')->references('id')->on('users');
			
			$table->enum('active_operator_team', ['CC','SP','SA','NW','ST','SCS'])->nullable()->index();
			$table->integer('active_operator_id')->unsigned()->nullable();
			$table->foreign('active_operator_id')->references('id')->on('users');
			
			$table->text('tier1_solve_description')->nullable();
			$table->boolean('tier1_solve_result');
			$table->enum('tier1_forward', ['SP','SA','NW','ST','SCS'])->nullable();
			
			$table->integer('tier2_solve_user_id')->unsigned()->nullable();
			$table->foreign('tier2_solve_user_id')->references('id')->on('users');
			$table->dateTime('tier2_solve_user_dtm')->nullable();
			$table->text('tier2_solve_description')->nullable();
			$table->boolean('tier2_solve_result')->nullable();
			$table->dateTime('tier2_solve_result_dtm')->nullable();
			$table->enum('tier2_forward', ['SA','NW','ST','SCS'])->nullable();
			
			$table->integer('tier3_solve_user_id')->unsigned()->nullable();
			$table->foreign('tier3_solve_user_id')->references('id')->on('users');
			$table->dateTime('tier3_solve_user_dtm')->nullable();
			$table->text('tier3_solve_description')->nullable();
			$table->boolean('tier3_solve_result')->nullable();
			$table->dateTime('tier3_solve_result_dtm')->nullable();
			$table->enum('tier3_forward', ['SCS'])->nullable();
			
			/*$table->integer('sp_solve_user_id')->unsigned()->nullable();
			$table->foreign('sp_solve_user_id')->references('id')->on('users');
			$table->dateTime('sp_solve_user_dtm')->nullable();
			$table->text('sp_solve_description')->nullable();
			$table->boolean('sp_solve_result')->nullable();
			$table->dateTime('sp_solve_result_dtm')->nullable();
			
			$table->integer('sa_solve_user_id')->unsigned()->nullable();
			$table->foreign('sp_solve_user_id')->references('id')->on('users');
			$table->dateTime('sp_solve_user_dtm')->nullable();
			$table->text('sp_solve_description')->nullable();
			$table->boolean('sp_solve_result')->nullable();
			$table->dateTime('sp_solve_result_dtm')->nullable();*/
			
			
			
			/*$table->enum('t1_solved_flag', ['Y','N'])->nullable();
			$table->dateTime('t1_solved_at')->nullable();
			$table->text('t2_description');
			$table->integer('t2_solved_id')->unsigned();
			$table->foreign('t2_solved_id')->references('id')->on('users');
			$table->enum('t2_solved_flag', ['Y','N'])->nullable();
			$table->dateTime('t2_solved_at')->nullable();
			$table->text('t3_description');
			$table->integer('t3_solved_id')->unsigned();
			$table->foreign('t3_solved_id')->references('id')->on('users');
			$table->enum('t3_solved_flag', ['Y','N'])->nullable();
			$table->dateTime('t3_solved_at')->nullable();
			$table->text('t4_description');
			$table->integer('t4_solved_id')->unsigned();
			$table->foreign('t4_solved_id')->references('id')->on('users');
			$table->enum('t4_solved_flag', ['Y','N'])->nullable();
			$table->dateTime('t4_solved_at')->nullable();
			$table->enum('result_flag', ['Y','N'])->nullable();
			$table->dateTime('result_at')->nullable();
			$table->text('remark');*/
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}
