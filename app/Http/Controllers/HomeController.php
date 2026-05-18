<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect('/');
        }

        return view('dashboard');
    }

    public function history(Request $request)
    {
        $userId = session('user_id');

        $query = DB::table('heart_rate_logs')
            ->where('user_id', $userId)
            ->orderBy('recorded_at', 'desc');

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $logs = $query->paginate(15)->withQueryString();

        $allLogs = DB::table('heart_rate_logs')
            ->where('user_id', $userId);

        $totalLogs = $allLogs->count();

        $avgBpm = $totalLogs
            ? round($allLogs->avg('bpm'))
            : 0;

        $maxBpm = $totalLogs
            ? $allLogs->max('bpm')
            : 0;

        $minBpm = $totalLogs
            ? $allLogs->min('bpm')
            : 0;

        $normalCount = DB::table('heart_rate_logs')
            ->where('user_id', $userId)
            ->where('status', 'Normal')
            ->count();

        $warningCount = DB::table('heart_rate_logs')
            ->where('user_id', $userId)
            ->where('status', 'Warning')
            ->count();

        $dangerCount = DB::table('heart_rate_logs')
            ->where('user_id', $userId)
            ->where('status', 'Danger')
            ->count();

        $latestLog = DB::table('heart_rate_logs')
            ->where('user_id', $userId)
            ->orderBy('recorded_at', 'desc')
            ->first();

        // Chart Data
        $chartData = DB::table('heart_rate_logs')
            ->where('user_id', $userId)
            ->orderBy('recorded_at', 'desc')
            ->limit(30)
            ->get()
            ->reverse()
            ->map(function ($log) {

                return [
                    'bpm' => $log->bpm,
                    'status' => $log->status,
                    'time' => Carbon::parse($log->recorded_at)
                        ->format('h:i A'),
                ];
            })
            ->values();

        return view('history', compact(
            'logs',
            'totalLogs',
            'avgBpm',
            'maxBpm',
            'minBpm',
            'normalCount',
            'warningCount',
            'dangerCount',
            'latestLog',
            'chartData'
        ));
    }


    // =========================
    // PATIENT LIST
    // =========================

    public function patients()
    {
        if (!session('user_id')) {
            return redirect('/');
        }

        $patients = DB::table('users')->get();

        return view('patients', compact('patients'));
    }


    // =========================
    // SPECIFIC PATIENT HISTORY
    // =========================

    public function patientHistory($id, Request $request)
    {
        if (!session('user_id')) {
            return redirect('/');
        }

        $patient = DB::table('users')
            ->where('id', $id)
            ->first();

        $query = DB::table('heart_rate_logs')
            ->where('user_id', $id)
            ->orderBy('recorded_at', 'desc');

        // Filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $logs = $query->paginate(15)->withQueryString();

        $allLogs = DB::table('heart_rate_logs')
            ->where('user_id', $id);

        $totalLogs = $allLogs->count();

        $avgBpm = $totalLogs
            ? round($allLogs->avg('bpm'))
            : 0;

        $maxBpm = $totalLogs
            ? $allLogs->max('bpm')
            : 0;

        $minBpm = $totalLogs
            ? $allLogs->min('bpm')
            : 0;

        $normalCount = DB::table('heart_rate_logs')
            ->where('user_id', $id)
            ->where('status', 'Normal')
            ->count();

        $warningCount = DB::table('heart_rate_logs')
            ->where('user_id', $id)
            ->where('status', 'Warning')
            ->count();

        $dangerCount = DB::table('heart_rate_logs')
            ->where('user_id', $id)
            ->where('status', 'Danger')
            ->count();

        $latestLog = DB::table('heart_rate_logs')
            ->where('user_id', $id)
            ->orderBy('recorded_at', 'desc')
            ->first();

        // Chart Data
        $chartData = DB::table('heart_rate_logs')
            ->where('user_id', $id)
            ->orderBy('recorded_at', 'desc')
            ->limit(30)
            ->get()
            ->reverse()
            ->map(function ($log) {

                return [
                    'bpm' => $log->bpm,
                    'status' => $log->status,
                    'time' => Carbon::parse($log->recorded_at)
                        ->format('h:i A'),
                ];
            })
            ->values();

        return view('history', compact(
            'patient',
            'logs',
            'totalLogs',
            'avgBpm',
            'maxBpm',
            'minBpm',
            'normalCount',
            'warningCount',
            'dangerCount',
            'latestLog',
            'chartData'
        ));
    }
}