<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private const HEART_RATE_DEVICE_CODE = 'ESP32-001';

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::table('users')->insert([
            'full_name' => $request->full_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/')->with('success', 'Account created successfully.');
    }

    public function showLogin()
    {
        return view('index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid email or password.');
        }

        session([
            'user_id' => $user->id,
            'full_name' => $user->full_name,
        ]);

        $device = DB::table('devices')
            ->where('device_code', self::HEART_RATE_DEVICE_CODE)
            ->first();

        if ($device) {
            DB::table('devices')
                ->where('id', $device->id)
                ->update([
                    'user_id' => $user->id,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('devices')->insert([
                'user_id' => $user->id,
                'device_code' => self::HEART_RATE_DEVICE_CODE,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/index');
    }
}
