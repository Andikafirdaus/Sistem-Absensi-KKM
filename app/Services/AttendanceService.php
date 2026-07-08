<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\QrToken;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use App\Models\ActivityLog;

class AttendanceService
{
    /**
     * Process QR scan — absen hanya SATU KALI per hari
     */
    public function processScan($user, $tokenString)
    {
        return DB::transaction(function () use ($user, $tokenString) {
            // Cek apakah akun aktif
            if (!$user->is_active) {
                throw new Exception("Akun Anda tidak aktif. Hubungi administrator.");
            }

            // Validasi token QR
            $qrToken = QrToken::where('token', $tokenString)
                ->where('is_active', true)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$qrToken) {
                throw new Exception("QR Code tidak valid atau sudah kadaluarsa.");
            }

            $today          = Carbon::today();
            $currentTime    = Carbon::now();
            $currentTimeStr = $currentTime->format('H:i:s');

            // Cek apakah sudah absen hari ini
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->first();

            if ($attendance) {
                // Sudah absen hari ini — tidak boleh absen lagi
                throw new Exception("Anda sudah melakukan absen hari ini pada pukul " . substr($attendance->check_in, 0, 5) . ". Absen hanya diperbolehkan satu kali per hari.");
            }

            // Tentukan status berdasarkan jam setting (Jika antara start_time dan end_time, maka Hadir)
            $settings = DB::table('settings')->first();
            $status   = 'Present';

            if ($settings && $settings->end_time) {
                // Anggap batas waktu absensi adalah jam pulang (end_time)
                $endTime = Carbon::parse($settings->end_time);
                
                // Jika absen dilakukan setelah jam 5 sore (melewati end_time), baru dianggap Terlambat
                if ($currentTime->greaterThan($endTime)) {
                    $status = 'Late';
                }
            }

            // Buat data absensi
            Attendance::create([
                'user_id'  => $user->id,
                'date'     => $today,
                'check_in' => $currentTimeStr,
                'status'   => $status,
            ]);

            // Catat log aktivitas
            $statusLabel = $status === 'Present' ? 'Hadir' : 'Terlambat';
            ActivityLog::create([
                'user_id'     => $user->id,
                'action'      => 'Absen',
                'description' => $user->name . ' melakukan absen pada pukul ' . substr($currentTimeStr, 0, 5) . ' — Status: ' . $statusLabel,
            ]);

            return [
                'success' => true,
                'message' => 'Absen berhasil! Pukul ' . substr($currentTimeStr, 0, 5) . ' — Status: ' . $statusLabel,
                'status'  => $statusLabel,
            ];
        });
    }
}
