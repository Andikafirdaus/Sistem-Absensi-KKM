<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Attendance::with('user')->latest();

            if ($request->has('date') && !empty($request->date)) {
                $data->whereDate('date', $request->date);
            }

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('user_name', function ($row) {

                    if (!$row->user) {
                        return '-';
                    }

                    if ($row->user->profile_photo_path) {

                        $photoPath = $row->user->profile_photo_path;

                        if (strpos($photoPath, 'profile-photos/') !== 0) {
                            $photoPath = 'profile-photos/' . $photoPath;
                        }

                        $photo = asset('public/uploads/' . $photoPath);

                        $avatar = '
                            <img src="'.$photo.'"
                                class="rounded-circle me-2"
                                width="36"
                                height="36"
                                style="object-fit: cover;">
                        ';

                    } else {

                        $avatar = '
                            <div class="rounded-circle bg-primary text-white d-inline-flex 
                                align-items-center justify-content-center me-2"
                                style="width:36px;height:36px;">
                                '.strtoupper(substr($row->user->name, 0, 1)).'
                            </div>
                        ';
                    }

                    return '
                        <div class="d-flex align-items-center">
                            '.$avatar.'
                            <span>'.$row->user->name.'</span>
                        </div>
                    ';
                })

                ->addColumn('user_divisi', function ($row) {
                    return $row->user->divisi ?? '-';
                })

                ->editColumn('date', function ($row) {
                    return Carbon::parse($row->date)
                        ->translatedFormat('d F Y');
                })

                ->editColumn('check_in', function ($row) {
                    return $row->check_in 
                        ? substr($row->check_in, 0, 5) 
                        : '-';
                })

                ->editColumn('status', function ($row) {

                    $status = strtolower($row->status);

                    if ($status === 'present') {

                        return '<span class="badge badge-saas badge-success-soft">
                                    Hadir
                                </span>';

                    } elseif ($status === 'late') {

                        return '<span class="badge badge-saas badge-warning-soft">
                                    Terlambat
                                </span>';

                    } elseif ($status === 'absent') {

                        return '<span class="badge badge-saas badge-danger-soft">
                                    Alpha
                                </span>';
                    }

                    return '<span class="badge badge-saas badge-primary-soft">'
                            . ucfirst($row->status) .
                           '</span>';
                })

                ->rawColumns([
                    'status',
                    'user_name'
                ])

                ->make(true);
        }

        return view('admin.attendances.index');
    }


    public function export(Request $request)
    {
        $startDate = $request->start_date ?? null;
        $endDate   = $request->end_date ?? null;

        $fileName = 'rekap_absensi_' . date('Y_m_d_H_i_s') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AttendanceExport($startDate, $endDate),
            $fileName
        );
    }
}