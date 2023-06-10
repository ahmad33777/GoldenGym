<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // schedule name
            $table->time('time_in'); //start ork
            $table->time('time_out'); // end work
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_trainers', function (Blueprint $table) {
 
            $table->foreignId('trainer_id')->constrained('trainers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onUpdate('cascade')->onDelete('cascade');


         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_trainers', function (Blueprint $table) {
            
            $table->dropForeign(['trainer_id']);
            $table->dropForeign(['schedule_id']);


            });
     
        Schema::dropIfExists('schedule_trainers');
        Schema::dropIfExists('schedules');
    }
};
