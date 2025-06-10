<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('occupation')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('gender');

            // Medical history
            $table->text('medications')->nullable()->after('medical_conditions');
            $table->text('surgeries')->nullable()->after('medications');
            $table->text('smoking_status')->nullable()->after('surgeries');
            $table->text('gi_symptoms')->nullable()->after('smoking_status');
            $table->text('recent_blood_test')->nullable()->after('gi_symptoms');

            // Food history
            $table->text('alcohol_intake')->nullable()->after('dietary_preferences');
            $table->text('coffee_intake')->nullable()->after('alcohol_intake');
            $table->text('vitamin_intake')->nullable()->after('coffee_intake');
            $table->text('daily_routine')->nullable()->after('vitamin_intake');
            $table->text('physical_activity_details')->nullable()->after('daily_routine');
            $table->text('previous_diets')->nullable()->after('physical_activity_details');
            $table->text('weight_history')->nullable()->after('previous_diets');
            $table->text('subscription_reason')->nullable()->after('weight_history');
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'occupation', 'birth_date',
                'medications', 'surgeries', 'smoking_status', 'gi_symptoms', 'recent_blood_test',
                'alcohol_intake', 'coffee_intake', 'vitamin_intake', 'daily_routine',
                'physical_activity_details', 'previous_diets', 'weight_history', 'subscription_reason'
            ]);
        });
    }
};
