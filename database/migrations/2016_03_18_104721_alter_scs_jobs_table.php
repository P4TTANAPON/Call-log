<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterScsJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scs_jobs', function (Blueprint $table) {
            $table->dateTime('action_dtm')->nullable();
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
            $table->dropColumn('action_dtm');
        });
    }
}
