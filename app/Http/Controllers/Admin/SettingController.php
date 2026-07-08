<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SettingRequest;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $setting = DB::table('settings')->first();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(SettingRequest $request)
    {
        $data = $request->validated();
        
        $setting = DB::table('settings')->first();
        
        if (!$setting) {
            DB::table('settings')->insert($data);
        } else {
            DB::table('settings')->where('id', $setting->id)->update($data);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Settings',
            'description' => 'Admin memperbarui pengaturan sistem'
        ]);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
