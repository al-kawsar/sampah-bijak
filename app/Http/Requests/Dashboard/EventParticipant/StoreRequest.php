<?php

namespace App\Http\Requests\Dashboard\EventParticipant;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:registered,attended,cancelled',
            'registered_at' => 'required|date|after_or_equal:today',
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
            'user_id.required' => 'User ID harus diisi.',
            'event_id.required' => 'Event ID harus diisi.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus salah satu dari: registered, attended, cancelled.',
            'registered_at.required' => 'Waktu pendaftaran harus diisi.',
        ];
    }
}
