<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterJobsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('last_call_category_id')->nullable();
            $table->string('last_primary_system_id')->nullable();
            $table->string('last_secondary_system_id')->nullable();
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
            $table->dropColumn('last_call_category_id');
            $table->dropColumn('last_primary_system_id');
            $table->dropColumn('last_secondary_system_id');
        });
    }
}
