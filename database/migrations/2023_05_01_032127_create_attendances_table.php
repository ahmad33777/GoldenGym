<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('id');
            $table->boolean('status')->default(0); //  هل حضر أو لا   اذا كان 0 يعني غائب اما اذا كان 1 يعني حضر 
            $table->date('date')->default(date("Y-m-d")); // تاريخ اليوم
            $table->time('attendance_time')->nullable(); // ساعة الحضور
            $table->time('leave_time')->nullable(); // ساعة الإنصراف
            $table->time('duration_time')->nullable(true); // فترة العمل للمدرب 
            $table->boolean('order_status')->nullable(true); // يعني مش مقبول   حالة الطلب            
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); // معرف الموظف
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
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });



        Schema::dropIfExists('attendances');
    }
};