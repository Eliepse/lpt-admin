<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameOfficesToCampus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('offices', 'campuses');
        Schema::table('schedules', function (Blueprint $table) {
            $table->renameColumn('office_id', 'campus_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('campuses', 'offices');
        Schema::table('schedules', function (Blueprint $table) {
            $table->renameColumn('campus_id', 'office_id');
        });
    }
}
