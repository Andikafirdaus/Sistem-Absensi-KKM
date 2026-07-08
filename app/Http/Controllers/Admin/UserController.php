<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            // Filters
            if ($request->has('divisi') && $request->divisi != '') {
                $query->where('divisi', $request->divisi);
            }
            if ($request->has('jurusan') && $request->jurusan != '') {
                $query->where('jurusan', $request->jurusan);
            }
            if ($request->has('status') && $request->status != '') {
                $query->where('is_active', $request->status);
            }

            $data = $query->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_info', function($row){
                    $avatar = $row->profile_photo_path 
                        ? '<img src="'.asset('public/uploads/'.$row->profile_photo_path).'" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">'
                        : '<div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; font-weight: bold;">'.strtoupper(substr($row->name, 0, 1)).'</div>';
                    
                    return '<div class="d-flex align-items-center">
                                '.$avatar.'
                                <div>
                                    <h6 class="mb-0 fw-bold"><a href="'.route('admin.users.show', $row->id).'" class="text-dark text-decoration-none">'.$row->name.'</a></h6>
                                    <small class="text-muted">'.$row->email.'</small>
                                </div>
                            </div>';
                })
                ->editColumn('is_active', function($row){
                    return $row->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('admin.users.show', $row->id).'" class="btn btn-info btn-sm text-white me-1" title="Detail"><i class="bi bi-eye"></i></a>';
                    $btn .= '<a href="'.route('admin.users.edit', $row->id).'" class="edit btn btn-primary btn-sm me-1" title="Edit"><i class="bi bi-pencil"></i></a>';
                    if (Auth::id() !== $row->id) {
                        $btn .= '<button class="delete btn btn-danger btn-sm" onclick="deleteUser('.$row->id.')" title="Hapus"><i class="bi bi-trash"></i></button>';
                    }
                    return $btn;
                })
                ->rawColumns(['user_info', 'action', 'is_active'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function show(User $user)
    {
        $attendances = \App\Models\Attendance::where('user_id', $user->id)->latest()->get();
        return view('admin.users.show', compact('user', 'attendances'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $this->userService->updateUser($user, $request->validated());
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user);
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
