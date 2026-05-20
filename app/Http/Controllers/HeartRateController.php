<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeartRateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'device_code' => 'required|string|exists:devices,device_code',
            'bpm' => 'required|integer',
            'status' => 'required|in:Normal,Warning,Danger',
        ]);

        $device = DB::table('devices')
            ->where('device_code', $request->device_code)
            ->first();

        DB::table('heart_rate_logs')->insert([
            'user_id' => $device->user_id,
            'bpm' => $request->bpm,
            'status' => $request->status,
            'recorded_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Heart rate stored successfully'
        ]);
        
    }

    public function latest()
    {
        if (!session('user_id')) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $latest = DB::table('heart_rate_logs')
            ->where('user_id', session('user_id'))
            ->latest('recorded_at')
            ->first();

        return response()->json($latest);
    }
}
