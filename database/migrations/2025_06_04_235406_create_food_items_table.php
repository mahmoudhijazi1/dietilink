<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('food_category_id');
            $table->string('name');
            $table->string('default_portion')->nullable(); // e.g., "1 cup", "100g"
            $table->integer('calories')->nullable();       // Optional
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('food_category_id')->references('id')->on('food_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_items');
    }
};
