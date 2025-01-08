<?php

namespace App\Http\Requests\Dashboard\PickupSchedule;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'user_id' => 'required|uuid|exists:users,id',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'ID pengguna harus diisi.',
            'user_id.uuid' => 'ID pengguna harus berupa UUID yang valid.',
            'user_id.exists' => 'ID pengguna tidak ditemukan dalam sistem.',
            'pickup_date.required' => 'Tanggal penjemputan harus diisi.',
            'pickup_date.date' => 'Tanggal penjemputan harus berupa format tanggal yang valid.',
            'pickup_date.after_or_equal' => 'Tanggal penjemputan tidak boleh sebelum hari ini.',
            'pickup_time.required' => 'Waktu penjemputan harus diisi.',
            'pickup_time.date_format' => 'Waktu penjemputan harus dalam format HH:mm.',
            'notes.string' => 'Catatan harus berupa teks.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
            'status.required' => 'Status penjemputan harus diisi.',
            'status.string' => 'Status penjemputan harus berupa teks.',
            'status.in' => 'Status penjemputan tidak valid (hanya: pending, confirmed, completed, cancelled).',
        ];
    }
}
