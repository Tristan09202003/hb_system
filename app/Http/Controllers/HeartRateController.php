<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeartRateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'bpm' => 'required|integer',
            'status' => 'required|in:Normal,Warning,Danger',
        ]);

        DB::table('heart_rate_logs')->insert([
            'user_id' => $request->user_id,
            'bpm' => $request->bpm,
            'status' => $request->status,
            'recorded_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Heart rate stored successfully'
        ]);
    }
}