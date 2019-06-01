<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string("location");
            $table->unsignedTinyInteger("max_students");
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->json('timetables');
            $table->date('first_day');
            $table->date('last_day');
            $table->dateTime('booking_open_at')->nullable();
            $table->dateTime('booking_close_at')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
