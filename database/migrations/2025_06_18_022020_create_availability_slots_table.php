<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('dietitian_id')->constrained()->onDelete('cascade');
            
            // Day of week: 0=Sunday, 1=Monday, ... 6=Saturday
            $table->tinyInteger('day_of_week')->comment('0=Sunday, 1=Monday, ... 6=Saturday');
            
            // Time slots
            $table->time('start_time');
            $table->time('end_time');
            
            // Optional: for future vacation/override functionality
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Ensure no duplicate day/time combinations per dietitian
            $table->unique(['dietitian_id', 'day_of_week', 'start_time', 'end_time'], 'unique_dietitian_slot');
            
            // Index for performance
            $table->index(['tenant_id', 'dietitian_id', 'day_of_week']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('availability_slots');
    }
};