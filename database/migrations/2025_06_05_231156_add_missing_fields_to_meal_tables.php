<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Add 'status' to meal_plans
        Schema::table('meal_plans', function (Blueprint $table) {
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft')->after('notes');
        });

        // Add 'order' to meals
        Schema::table('meals', function (Blueprint $table) {
            $table->unsignedInteger('order')->default(0)->after('note');
        });

        // Add 'order' to meal_items
        Schema::table('meal_items', function (Blueprint $table) {
            $table->unsignedInteger('order')->default(0)->after('notes');
        });
    }

    public function down()
    {
        Schema::table('meal_plans', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        Schema::table('meal_items', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
