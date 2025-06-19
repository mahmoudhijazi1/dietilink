<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointment_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dietitian_id')->constrained('dietitians')->onDelete('cascade');
            $table->string('name'); // e.g., "Initial Consultation", "Follow-up"
            $table->integer('duration_minutes'); // e.g., 30, 60, 90
            $table->string('color', 7)->default('#3B82F6'); // hex color for calendar display
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); // for ordering in dropdowns
            $table->timestamps();

            // Ensure unique names per dietitian
            $table->unique(['dietitian_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_types');
    }
};