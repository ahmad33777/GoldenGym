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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('cascade')->nullable(false);
            $table->string('image')->nullable(true);
            $table->double('base_price')->nullable(false);
            $table->double('discount')->nullable(true)->default(0);
            $table->integer('quantity')->nullable(false);
            $table->string('description')->nullable(true);
            $table->date('production_date')->nullable(true);
            $table->date('expiry_date')->nullable(true);
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
        Schema::dropIfExists('products');
    }
};