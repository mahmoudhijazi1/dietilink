<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('meal_plan_id');
            $table->string('type'); // lunch, dinner, etc.
            $table->string('title')->nullable(); // Option 1, Option 2
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('meal_plan_id')->references('id')->on('meal_plans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('meals');
    }
};
