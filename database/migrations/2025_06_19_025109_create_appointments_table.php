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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dietitian_id')->constrained('dietitians')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('appointment_type_id')->constrained('appointment_types')->onDelete('restrict');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['scheduled', 'completed', 'canceled', 'no_show'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->text('dietitian_notes')->nullable(); // private notes for dietitian
            $table->foreignId('created_by_user_id')->constrained('users')->onDelete('restrict');
            $table->timestamp('canceled_at')->nullable();
            $table->foreignId('canceled_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            // Prevent overlapping appointments for same dietitian
            $table->unique(['dietitian_id', 'appointment_date', 'start_time'], 'unique_dietitian_datetime');
            
            // Index for quick lookups
            $table->index(['dietitian_id', 'appointment_date']);
            $table->index(['patient_id', 'appointment_date']);
            $table->index(['appointment_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};