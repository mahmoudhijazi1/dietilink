<?php
// database/migrations/xxxx_xx_xx_create_patients_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->float('height')->nullable();
            $table->float('initial_weight')->nullable();
            $table->float('goal_weight')->nullable();
            $table->string('activity_level')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->text('allergies')->nullable();
            $table->text('dietary_preferences')->nullable();
            $table->text('notes')->nullable();
            $table->json('additional_info')->nullable(); // For flexible/future data
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
