<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string("title");
            $table->string("location");
            $table->enum("country", ["france"]);
            $table->unsignedBigInteger("teacher_id")->nullable();
            $table->unsignedTinyInteger("level")->nullable();
            $table->unsignedTinyInteger("max_students");
            $table->unsignedSmallInteger("price");
            $table->set("timetable_days", ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"]);
            $table->time("timetable_hour");
            $table->date("first_day");
            $table->date("last_day");
            $table->dateTime("booking_open_at")->nullable();
            $table->dateTime("booking_close_at")->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('grades');
        Schema::enableForeignKeyConstraints();
    }
}
