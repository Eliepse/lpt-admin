<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChineseNameFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname_zh')->nullable()->after('firstname');
            $table->string('lastname_zh')->nullable()->after('lastname');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('firstname_zh')->nullable()->after('firstname');
            $table->string('lastname_zh')->nullable()->after('lastname');
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
            $table->dropColumn(['firstname_zh', 'lastname_zh']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['firstname_zh', 'lastname_zh']);
        });
    }
}
