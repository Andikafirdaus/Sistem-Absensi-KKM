<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\QrToken;
use App\Models\WorkHour;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function scan()
    {
        $attendanceToday = \App\Models\Attendance::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereDate('date', \Carbon\Carbon::today())
            ->first();
        return view('user.scan', compact('attendanceToday'));
    }

    protected $attendanceService;

    public function __construct(\App\Services\AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        try {
            $result = $this->attendanceService->processScan(Auth::user(), $request->token);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $query = Attendance::where('user_id', $user->id);

            if ($request->has('month') && $request->month != '') {
                $query->whereMonth('date', $request->month);
            }
            if ($request->has('year') && $request->year != '') {
                $query->whereYear('date', $request->year);
            }
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $data = $query->latest();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('date', function ($row) {
                    return Carbon::parse($row->date)->translatedFormat('d F Y');
                })
                ->editColumn('check_in', function ($row) {
                    return $row->check_in ? substr($row->check_in, 0, 5) : '-';
                })
                ->editColumn('status', function ($row) {
                    $status = strtolower($row->status);
                    if ($status === 'present') {
                        return '<span class="badge badge-saas badge-success-soft">Hadir</span>';
                    }
                    if ($status === 'late') {
                        return '<span class="badge badge-saas badge-warning-soft">Terlambat</span>';
                    }
                    if ($status === 'absent') {
                        return '<span class="badge badge-saas badge-danger-soft">Alpha</span>';
                    }
                    return '<span class="badge badge-saas badge-primary-soft">' . ucfirst($row->status) . '</span>';
                })
                ->editColumn('notes', function ($row) {
                    return $row->notes ?: '-';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('user.history');
    }
}
