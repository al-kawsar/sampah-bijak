<?php

namespace App\Http\Requests\Dashboard\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Bisa dikustomisasi dengan kondisi authorization
    }

    /**
     * Tentukan aturan validasi untuk request ini.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date|after_or_equal:today',
            'location' => 'sometimes|string|max:255',
            'organizer_id' => 'sometimes|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'max_participants' => 'sometimes|integer|min:1',
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
            'title.required' => 'Judul acara harus diisi.',
            'description.required' => 'Deskripsi acara harus diisi.',
            'date.required' => 'Tanggal acara harus diisi.',
            'location.required' => 'Lokasi acara harus diisi.',
            'organizer_id.required' => 'Organizer acara harus dipilih.',
            'image.image' => 'File gambar harus berupa gambar.',
            'max_participants.required' => 'Jumlah peserta maksimal harus diisi.',
        ];
    }
}
