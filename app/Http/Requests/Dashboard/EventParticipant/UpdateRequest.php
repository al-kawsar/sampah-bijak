<?php

namespace App\Http\Requests\Dashboard\EventParticipant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Anda bisa menambahkan otorisasi sesuai kebutuhan
    }

    /**
     * Tentukan aturan validasi untuk request ini.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:registered,attended,cancelled',
        ];
    }

    /**
     * Tentukan pesan error kustom jika diperlukan.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus salah satu dari: registered, attended, cancelled.',
        ];
    }
}
