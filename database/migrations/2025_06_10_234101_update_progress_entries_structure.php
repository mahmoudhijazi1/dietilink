<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('progress_entries', function (Blueprint $table) {

            $table->decimal('chest', 5, 2)->nullable();
            $table->decimal('left_arm', 5, 2)->nullable();
            $table->decimal('right_arm', 5, 2)->nullable();
            $table->decimal('waist', 5, 2)->nullable();
            $table->decimal('hips', 5, 2)->nullable();
            $table->decimal('left_thigh', 5, 2)->nullable();
            $table->decimal('right_thigh', 5, 2)->nullable();

            $table->decimal('fat_mass', 5, 2)->nullable();
            $table->decimal('muscle_mass', 5, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('progress_entries', function (Blueprint $table) {

            $table->dropColumn([
                'chest',
                'left_arm',
                'right_arm',
                'waist',
                'hips',
                'left_thigh',
                'right_thigh',
                'fat_mass',
                'muscle_mass',
            ]);
        });
    }
};
