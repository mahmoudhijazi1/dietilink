<?php
// database/migrations/xxxx_xx_xx_create_progress_entries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('progress_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->float('weight')->nullable();
            $table->json('measurements')->nullable(); // e.g., { "waist": 80, "hips": 100 }
            $table->text('notes')->nullable();
            $table->date('measurement_date')->default(now());
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_entries');
    }
};
