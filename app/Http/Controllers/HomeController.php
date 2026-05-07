<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
 
    // Filter by status if provided
    if ($request->status) {
        $query->where('status', $request->status);
    }
 
    $logs      = $query->paginate(15)->withQueryString();
    $allLogs   = DB::table('heart_rate_logs')->where('user_id', $userId);
 
    $totalLogs    = $allLogs->count();
    $avgBpm       = $totalLogs ? round($allLogs->avg('bpm')) : 0;
    $maxBpm       = $totalLogs ? $allLogs->max('bpm') : 0;
    $minBpm       = $totalLogs ? $allLogs->min('bpm') : 0;
    $normalCount  = DB::table('heart_rate_logs')->where('user_id', $userId)->where('status', 'Normal')->count();
    $warningCount = DB::table('heart_rate_logs')->where('user_id', $userId)->where('status', 'Warning')->count();
    $dangerCount  = DB::table('heart_rate_logs')->where('user_id', $userId)->where('status', 'Danger')->count();
    $latestLog    = DB::table('heart_rate_logs')->where('user_id', $userId)->orderBy('recorded_at', 'desc')->first();
 
    // Chart data — last 30 logs (oldest first for trend)
    $chartData = DB::table('heart_rate_logs')
        ->where('user_id', $userId)
        ->orderBy('recorded_at', 'desc')
        ->limit(30)
        ->get()
        ->reverse()
        ->map(fn($log) => [
            'bpm'    => $log->bpm,
            'status' => $log->status,
            'time'   => \Carbon\Carbon::parse($log->recorded_at)->format('h:i A'),
        ])
        ->values();
 
    return view('history', compact(
        'logs', 'totalLogs', 'avgBpm', 'maxBpm', 'minBpm',
        'normalCount', 'warningCount', 'dangerCount',
        'latestLog', 'chartData'
    ));
}
}