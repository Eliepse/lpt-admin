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
            $table->string("location");
            $table->enum("country", ["france"]);
            $table->unsignedBigInteger("teacher_id")->nullable();
            $table->unsignedTinyInteger("level");
            $table->date("date_start_at");
            $table->date("date_end_at");
            $table->set("days", [1, 2, 3, 4, 5, 6, 7]);
            $table->time("timetable_start_at");
            $table->time("timetable_end_at");
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
        Schema::dropIfExists('grades');
    }
}
