<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
//            $table->set('role', ['admin'])->nullable();
            $table->enum('type', ['admin', 'teacher', 'parent'])->default('parent');
            $table->string('wechat_id')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
//            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean("active")->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
