<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('schedule_id')
                ->references('id')->on('schedules')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('course_lesson', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('lesson_id')
                ->references('id')->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onUpdate('cascade')
                ->onDelete('RESTRICT');
            $table->foreign('campus_id')
                ->references('id')->on('campuses')
                ->onUpdate('cascade')
                ->onDelete('RESTRICT');
        });

        Schema::table('schedule_teacher', function (Blueprint $table) {
            $table->foreign('schedule_id')
                ->references('id')->on('schedules')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('teacher_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger("student_id")->nullable()->change();
            $table->foreign('student_id')
                ->references('id')->on('students')
                ->onUpdate('cascade')
                ->onUpdate('set null');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign('attendances_schedule_id_foreign');
        });

        Schema::table('course_lesson', function (Blueprint $table) {
            $table->dropForeign('course_lesson_course_id_foreign');
            $table->dropForeign('course_lesson_lesson_id_foreign');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign('schedules_course_id_foreign');
            $table->dropForeign('schedules_campus_id_foreign');
        });

        Schema::table('schedule_teacher', function (Blueprint $table) {
            $table->dropForeign('schedule_teacher_schedule_id_foreign');
            $table->dropForeign('schedule_teacher_teacher_id_foreign');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_student_id_foreign');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger("student_id")->nullable(false)->change();
        });
        Schema::enableForeignKeyConstraints();
    }
}
