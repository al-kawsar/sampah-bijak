<?php

namespace App\Http\Requests\Dashboard\Notification;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan kebijakan otorisasi aplikasi Anda.
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string|max:500',
            'type' => 'sometimes|required|string|in:info,warning,error,success',
            'is_read' => 'sometimes|required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul notifikasi harus diisi.',
            'title.string' => 'Judul notifikasi harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'message.required' => 'Pesan notifikasi harus diisi.',
            'message.string' => 'Pesan notifikasi harus berupa teks.',
            'message.max' => 'Pesan maksimal 500 karakter.',
            'type.required' => 'Jenis notifikasi harus diisi.',
            'type.string' => 'Jenis notifikasi harus berupa teks.',
            'type.in' => 'Jenis notifikasi tidak valid (hanya: info, warning, error, success).',
            'is_read.required' => 'Status baca harus diisi.',
            'is_read.boolean' => 'Status baca harus berupa nilai boolean (true/false).',
        ];
    }
}
