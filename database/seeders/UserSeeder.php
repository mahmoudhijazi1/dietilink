<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Tenant
        $tenantId = DB::table('tenants')->insertGetId([
            'name' => 'Dr. Sarah Clinic',
            'status' => 'active',
            'subscription_type' => 'trial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'tenant_id' => null,
        ]);

        // Dietitian
        $dietitianUser = User::create([
            'name' => 'Dr. Sarah Dietitian',
            'email' => 'dietitian@example.com',
            'password' => Hash::make('password'),
            'role' => 'dietitian',
            'tenant_id' => $tenantId,
        ]);
        DB::table('dietitians')->insert([
            'user_id' => $dietitianUser->id,
            'clinic_name' => 'Wellness Clinic',
            'phone' => '123456789',
            'bio' => 'Specialist in nutrition.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Patient
        $patientUser = User::create([
            'name' => 'John Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'tenant_id' => $tenantId,
        ]);
        DB::table('patients')->insert([
            'user_id' => $patientUser->id,
            'height' => 170,
            'initial_weight' => 80,
            'goal_weight' => 70,
            'activity_level' => 'moderate',
            'additional_info' => json_encode(['allergies' => ['nuts', 'pollen']]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
