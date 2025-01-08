<?php

namespace App\Http\Requests\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user')->id;

        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
            'region_id' => 'required|exists:regions,id',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'region_id.required' => 'Wilayah wajib dipilih.',
            'region_id.exists' => 'Wilayah tidak valid.',
            'role_id.required' => 'Peran wajib dipilih.',
            'role_id.exists' => 'Peran tidak valid.',
        ];
    }
}
