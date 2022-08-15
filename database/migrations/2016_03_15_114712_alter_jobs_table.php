<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
			$table->index('created_at', 'jobs_created_at_index');
			$table->index('last_operator_team', 'jobs_last_operator_team_index');
            $table->string('counter');
            $table->string('screen_id');
			$table->boolean('return_job')->default('0');
			$table->integer('cc_confirm_closed_id')->unsigned()->nullable();
			$table->foreign('cc_confirm_closed_id')->references('id')->on('users');
			$table->boolean('cc_confirm_closed')->default('0');
			$table->dateTime('cc_confirm_closed_dtm')->nullable();
			
			$table->integer('scs_solve_user_id')->unsigned()->nullable();
			$table->foreign('scs_solve_user_id')->references('id')->on('users');
			$table->dateTime('scs_solve_user_dtm')->nullable();
			$table->dateTime('scs_solve_result_dtm')->nullable();
			//$table->dateTime('scs_solve_result_enter_dtm')->nullable();
			
			$table->integer('sa_rw_id')->unsigned()->nullable();
			$table->foreign('sa_rw_id')->references('id')->on('users');
			$table->dateTime('sa_rw_dtm')->nullable();
			
			$table->boolean('sa_rw')->default('0');
			$table->integer('sa_rw_call_category_id')->unsigned()->nullable();
			$table->foreign('sa_rw_call_category_id')->references('id')->on('call_categories');
			$table->integer('sa_rw_primary_system_id')->unsigned()->nullable();
			$table->foreign('sa_rw_primary_system_id')->references('id')->on('systems');
			$table->integer('sa_rw_secondary_system_id')->unsigned()->nullable();
			$table->foreign('sa_rw_secondary_system_id')->references('id')->on('systems');
			$table->boolean('sa_rw_return_job')->default('0');
			$table->text('sa_rw_remark')->nullable();
			
			$table->string('phase', 2);
        });
    }
	
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex('jobs_created_at_index');
            $table->dropIndex('jobs_last_operator_team_index');
			
			$table->dropForeign('jobs_cc_confirm_closed_id_foreign');
			$table->dropForeign('jobs_scs_solve_user_id_foreign');
			$table->dropForeign('jobs_sa_rw_id_foreign');
			$table->dropForeign('jobs_sa_rw_call_category_id_foreign');
			$table->dropForeign('jobs_sa_rw_primary_system_id_foreign');
			$table->dropForeign('jobs_sa_rw_secondary_system_id_foreign');
			
			$table->dropColumn('counter');
			$table->dropColumn('screen_id');
			$table->dropColumn('return_job');
			$table->dropColumn('cc_confirm_closed_id');
			$table->dropColumn('cc_confirm_closed');
			$table->dropColumn('cc_confirm_closed_dtm');
			
			$table->dropColumn('scs_solve_user_id');
			$table->dropColumn('scs_solve_user_dtm');
			$table->dropColumn('scs_solve_result_dtm');
			//$table->dropColumn('scs_solve_result_enter_dtm');
			
			$table->dropColumn('sa_rw');
			$table->dropColumn('sa_rw_id');
			$table->dropColumn('sa_rw_dtm');
			$table->dropColumn('sa_rw_call_category_id');
			$table->dropColumn('sa_rw_primary_system_id');
			$table->dropColumn('sa_rw_secondary_system_id');
			$table->dropColumn('sa_rw_return_job');
			$table->dropColumn('sa_rw_remark');
			
			$table->dropColumn('phase');
        });
    }
}
