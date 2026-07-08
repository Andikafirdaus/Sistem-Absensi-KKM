<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrToken;
use Carbon\Carbon;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    public function index()
    {
        $token = QrToken::where('is_active', true)->where('expires_at', '>', Carbon::now())->latest()->first();
        return view('admin.qrcode.index', compact('token'));
    }

    public function generate(Request $request)
    {
        // Fetch settings
        $settings = \Illuminate\Support\Facades\DB::table('settings')->first();
        $validityMinutes = $settings->qr_validity_minutes ?? 5;

        return \Illuminate\Support\Facades\DB::transaction(function () use ($validityMinutes) {
            QrToken::where('is_active', true)->update(['is_active' => false]);

            $token = QrToken::create([
                'token' => Str::random(40),
                'expires_at' => Carbon::now()->addMinutes($validityMinutes),
                'is_active' => true
            ]);
            
            return response()->json([
                'success' => true,
                'token' => $token->token,
                'expires_at' => $token->expires_at
            ]);
        });
    }
}
