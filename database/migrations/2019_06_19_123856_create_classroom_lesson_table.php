<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_lesson', function (Blueprint $table) {
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->smallInteger('duration');
//            $table->tinyInteger('position');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_lesson');
    }
}
