<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('family_id')
                ->references('id')
                ->on('families')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreign('family_id')
                ->references('id')
                ->on('families')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign("users_family_id_foreign");
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign("students_family_id_foreign");
        });

        Schema::dropIfExists('families');
    }
}
