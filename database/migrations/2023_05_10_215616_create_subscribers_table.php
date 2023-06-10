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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('userName')->nullable(false);
            $table->string('phone')->nullable();
            $table->integer('age')->nullable();
            $table->double('weight')->nullable();
            $table->double('height')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('health_status')->nullable();
            $table->date('subscription_start')->nullable(false);
            $table->date('subscription_end')->nullable(false);
            $table->foreignId('subscription_id')->constrained('subscriptions')->onUpdate('cascade')->onDelete('cascade')->nullable(false);
            $table->foreignId('trainer_id')->constrained('trainers')->onUpdate('cascade')->onDelete('cascade')->nullable(false);
            $table->double('first_batch')->nullable();
            $table->double('indebtedness')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true); // is active = true = 1  |||  fasle  == notActive =  0
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(false);
            $table->rememberToken();
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
        Schema::dropIfExists('subscribers');
    }
};