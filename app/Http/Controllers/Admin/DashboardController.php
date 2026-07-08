<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\ActivityLog;
use App\Models\QrToken;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $totalUsers = User::where('role', 'user')->count();
        $totalPresentToday = Attendance::whereDate('date', $today)->where('status', 'Present')->count();
        $totalLateToday = Attendance::whereDate('date', $today)->where('status', 'Late')->count();
        $totalAbsentToday = max(0, $totalUsers - ($totalPresentToday + $totalLateToday));
        
        $attendancePercentage = $totalUsers > 0 
            ? round((($totalPresentToday + $totalLateToday) / $totalUsers) * 100, 1) 
            : 0;

        $activeQr = QrToken::where('is_active', true)
            ->where('expires_at', '>', Carbon::now())
            ->count();
            
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();
            
$recentAttendances = Attendance::with('user')
    ->whereDate('date', $today)
    ->latest()
    ->get();
        
        // Simple 7-days chart data
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $present = Attendance::whereDate('date', $date)->where('status', 'Present')->count();
            $late = Attendance::whereDate('date', $date)->where('status', 'Late')->count();
            $chartData['labels'][] = $date->format('d M');
            $chartData['present'][] = $present;
            $chartData['late'][] = $late;
        }

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalPresentToday', 
            'totalLateToday',
            'totalAbsentToday',
            'attendancePercentage',
            'activeQr',
            'recentActivities',
            'recentAttendances',
            'chartData'
        ));
    }
}
