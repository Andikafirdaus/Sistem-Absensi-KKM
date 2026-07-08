<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'name' => 'required|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => $userId ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'role' => 'nullable|in:admin,user',
            'is_active' => 'boolean'
        ];
    }
}
