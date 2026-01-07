<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BugReport;
use App\Models\DataRequest;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $userId = auth()->id();

        // Bug report stats
        $bugReportStats = [
            'total' => BugReport::where('user_id', $userId)->count(),
            'diajukan' => BugReport::where('user_id', $userId)->where('status', 'diajukan')->count(),
            'diproses' => BugReport::where('user_id', $userId)->whereIn('status', ['diverifikasi', 'diproses'])->count(),
            'selesai' => BugReport::where('user_id', $userId)->where('status', 'selesai')->count(),
        ];

        // Data request stats
        $dataRequestStats = [
            'total' => DataRequest::where('user_id', $userId)->count(),
            'diajukan' => DataRequest::where('user_id', $userId)->where('status', 'diajukan')->count(),
            'diproses' => DataRequest::where('user_id', $userId)->where('status', 'diproses')->count(),
            'tersedia' => DataRequest::where('user_id', $userId)->where('status', 'tersedia')->count(),
        ];

        // Recent bug reports
        $recentBugReports = BugReport::where('user_id', $userId)
            ->with(['application', 'vulnerabilityType'])
            ->latest()
            ->take(5)
            ->get();

        // Recent data requests
        $recentDataRequests = DataRequest::where('user_id', $userId)
            ->with(['opd'])
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'bugReportStats',
            'dataRequestStats',
            'recentBugReports',
            'recentDataRequests'
        ));
    }
}
