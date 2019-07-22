<?php

use App\Sets\DaysSet;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('office_id');
            $table->set('day', DaysSet::getKeys());
            $table->time('hour');
            $table->smallInteger('price')->default(0);
            $table->date('start_at');
            $table->date('end_at');
            $table->unsignedTinyInteger("max_students");
            $table->date('signup_start_at')->nullable();
            $table->date('signup_end_at')->nullable();
            $table->timestamps();
        });

//        TODO(eliepse): create all foreign keys

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
