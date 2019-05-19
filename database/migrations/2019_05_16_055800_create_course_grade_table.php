<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_grade', function (Blueprint $table) {
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('course_id');
//            $table->unsignedTinyInteger('position');

            // TODO add foreign keys
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_course');
    }
}
