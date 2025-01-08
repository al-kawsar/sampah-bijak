<?php

namespace App\Http\Requests\Dashboard\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
            'capacity' => 'required|integer|min:1',
            'thumbnail_url' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'thumbnail_url.required' => 'Thumbnail wajib diunggah.',
            'thumbnail_url.file' => 'Thumbnail harus berupa file.',
            'thumbnail_url.mimes' => 'Thumbnail harus berupa file dengan format jpg, jpeg, atau png.',
            'thumbnail_url.max' => 'Ukuran thumbnail maksimal adalah 2MB.',
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
            'image.image' => 'File gambar harus berupa gambar.',
            'capacity.required' => 'Jumlah peserta maksimal harus diisi.',
        ];
    }
}
