<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $user_id = Auth::id();
        
        $attendanceToday = Attendance::where('user_id', $user_id)
            ->whereDate('date', $today)
            ->first();

        // Data bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalPresent = Attendance::where('user_id', $user_id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['Present', 'Late'])
            ->count();
            
        $totalLate = Attendance::where('user_id', $user_id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('status', 'Late')
            ->count();

        // Asumsi hari kerja (misal Senin-Jumat) dalam bulan berjalan. 
        // Untuk sederhananya kita hitung dari tanggal 1 sampai hari ini, tapi lebih baik persentase dari yang seharusnya hadir.
        // Jika belum ada workdays spesifik, kita bisa asumsikan 100% jika present > 0, atau kita tidak usah tampilkan persentase yang rumit, cukup:
        // (Total Hadir / Jumlah Hari Berlalu di Bulan Ini) * 100
        $daysPassed = $today->day;
        // Opsional: kurangi weekend. Tapi kita akan gunakan simple persentase.
        $persentase = $daysPassed > 0 ? round(($totalPresent / $daysPassed) * 100) : 0;
        if ($persentase > 100) $persentase = 100;

        return view('user.dashboard', compact('attendanceToday', 'totalPresent', 'totalLate', 'persentase'));
    }
}
