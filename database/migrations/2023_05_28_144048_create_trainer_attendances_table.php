<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_attendances', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('trainer_id')->constrained('trainers')->onUpdate('cascade')->onDelete('cascade')->nullable(false);
            $table->date('date')->default(date("Y/m/d")); // تاريخ اليوم
            $table->time('attendance_time')->nullable(); // ساعة الحضور
            $table->time('leave_time')->nullable(); // ساعة الإنصراف
            $table->time('duration_time')->nullable(true); // فترة العمل للمدرب 
            $table->boolean('order_status')->nullable(true); // يعني مش مقبول   حالة الطلب 
            $table->boolean('status_late')->default(false); //متأخر
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer_attendances');
    }
};