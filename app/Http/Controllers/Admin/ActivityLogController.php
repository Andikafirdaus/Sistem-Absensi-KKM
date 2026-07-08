<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Auto hapus log lebih dari 7 hari
        ActivityLog::where(
            'created_at',
            '<',
            Carbon::now()->subDays(7)
        )->delete();


        if ($request->ajax()) {

            $data = ActivityLog::with('user')->latest();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('user_name', function($row){

                    return $row->user
                        ? $row->user->name
                        : 'Sistem';

                })

                ->editColumn('created_at', function($row){

                    return $row->created_at
                        ->format('Y-m-d H:i:s');

                })

                ->make(true);
        }


        return view('admin.activity_logs.index');
    }
    public function clear()
{
    ActivityLog::truncate();

    return redirect()
        ->route('admin.activity-logs.index')
        ->with('success', 'Semua log aktivitas berhasil dihapus.');
}
}