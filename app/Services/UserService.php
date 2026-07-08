<?php

namespace App\Services;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class UserService
{
    /**
     * Create a new user
     */
    public function createUser(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'jabatan' => $data['jabatan'] ?? null,
                'divisi' => $data['divisi'] ?? null,
                'jurusan' => $data['jurusan'] ?? null,
                'angkatan' => $data['angkatan'] ?? null,
                'nomor_hp' => $data['nomor_hp'] ?? null,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'is_active' => $data['is_active'] ?? true,
            ]);

            $this->logActivity('Create User', "Created user: {$user->name} ({$user->email}) with role {$user->role}");

            return $user;
        });
    }

    /**
     * Update an existing user
     */
    public function updateUser(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            // Prevent downgrading the last admin
            if ($user->role === 'admin' && $data['role'] !== 'admin') {
                $adminCount = User::where('role', 'admin')->count();
                if ($adminCount <= 1) {
                    throw new Exception("Cannot downgrade the last administrator.");
                }
            }

            $user->name = $data['name'];
            if (array_key_exists('jabatan', $data)) $user->jabatan = $data['jabatan'];
            if (array_key_exists('divisi', $data)) $user->divisi = $data['divisi'];
            if (array_key_exists('jurusan', $data)) $user->jurusan = $data['jurusan'];
            if (array_key_exists('angkatan', $data)) $user->angkatan = $data['angkatan'];
            if (array_key_exists('nomor_hp', $data)) $user->nomor_hp = $data['nomor_hp'];
            $user->email = $data['email'];
            $user->role = $data['role'];
            $user->is_active = $data['is_active'] ?? true;
            
            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            
            $user->save();

            $this->logActivity('Update User', "Updated user: {$user->name} ({$user->email})");

            return $user;
        });
    }

    /**
     * Delete a user
     */
    public function deleteUser(User $user)
    {
        return DB::transaction(function () use ($user) {
            // Prevent deleting self
            if ($user->id === Auth::id()) {
                throw new Exception("You cannot delete your own account.");
            }

            // Prevent deleting last admin
            if ($user->role === 'admin') {
                $adminCount = User::where('role', 'admin')->count();
                if ($adminCount <= 1) {
                    throw new Exception("Cannot delete the last administrator.");
                }
            }

            $userName = $user->name;
            $userEmail = $user->email;
            
            $user->delete();

            $this->logActivity('Delete User', "Deleted user: {$userName} ({$userEmail})");

            return true;
        });
    }

    /**
     * Helper to log activity
     */
    private function logActivity($action, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description
        ]);
    }
}
