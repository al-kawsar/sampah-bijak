<?php

namespace App\Http\Requests\Dashboard\WasteReminder;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'reminder_time' => 'required|date_format:H:i',
            'frequency' => 'required|in:daily,weekly,monthly',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Get the validation messages in Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul pengingat wajib diisi.',
            'title.string' => 'Judul pengingat harus berupa teks.',
            'title.max' => 'Judul pengingat tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi pengingat wajib diisi.',
            'description.string' => 'Deskripsi pengingat harus berupa teks.',
            'description.max' => 'Deskripsi pengingat tidak boleh lebih dari 1000 karakter.',
            'reminder_time.required' => 'Waktu pengingat wajib diisi.',
            'reminder_time.date_format' => 'Format waktu pengingat harus HH:MM.',
            'frequency.required' => 'Frekuensi pengingat wajib dipilih.',
            'frequency.in' => 'Frekuensi pengingat tidak valid.',
            'is_active.required' => 'Status aktif wajib diisi.',
            'is_active.boolean' => 'Status aktif harus berupa nilai boolean.',
        ];
    }
}
