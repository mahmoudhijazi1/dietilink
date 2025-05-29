<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            // Optionally, redirect based on role, for now redirect to index
            return redirect()->route('index');
        } else {
            $validator->errors()->add(
                'password', 'The password does not match with username'
            );
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function registerView()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(7)],
            // Optionally add: 'role' => ['required', 'in:patient,dietitian']
        ]);

        $validated = $validator->validated();

        // For MVP: default everyone to dietitian unless you pass role from the form
        $role = $request->input('role', 'dietitian');

        $tenant_id = null;
        if ($role == 'dietitian') {
            // Create a new tenant for every new dietitian
            $tenant = Tenant::create([
                'name' => $validated['name'] . " Clinic",
                'status' => 'active',
                'subscription_type' => 'trial', // Default or customize
            ]);
            $tenant_id = $tenant->id;
        } elseif ($role == 'patient') {
            // For now, patients have no tenant unless you handle this
            // You can update this to require a dietitian/tenant in the form if needed
        }

        $user = User::create([
            'name'      => $validated["name"],
            'email'     => $validated["email"],
            'password'  => Hash::make($validated["password"]),
            'role'      => $role,
            'tenant_id' => $tenant_id,
        ]);

        Auth::login($user);

        return redirect()->route('index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
