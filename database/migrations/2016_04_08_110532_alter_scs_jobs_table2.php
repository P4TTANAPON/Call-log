<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterScsJobsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scs_jobs', function (Blueprint $table) {
            $table->dateTime('start_dtm')->nullable();
			$table->string('operator_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scs_jobs', function (Blueprint $table) {
            $table->dropColumn('start_dtm');
            $table->dropColumn('operator_name');
        });
    }
}
