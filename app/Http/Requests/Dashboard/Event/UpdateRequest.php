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
        return true;
    }


    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date_format:Y-m-d H:i:s',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'thumbnail_url' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
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
            'title.string' => 'Judul acara harus berupa teks.',
            'title.max' => 'Judul acara tidak boleh lebih dari 255 karakter.',

            'thumbnail_url.file' => 'File yang diunggah harus berupa file.',
            'thumbnail_url.mimes' => 'File harus berupa gambar dengan format jpg, jpeg, atau png.',
            'thumbnail_url.max' => 'File gambar tidak boleh lebih dari 2MB.',

            'description.required' => 'Deskripsi acara harus diisi.',
            'description.string' => 'Deskripsi acara harus berupa teks.',

            'date.required' => 'Tanggal acara harus diisi.',
            'date.date' => 'Tanggal acara harus berupa tanggal yang valid.',

            'location.required' => 'Lokasi acara harus diisi.',
            'location.string' => 'Lokasi acara harus berupa teks.',

            'capacity.required' => 'Kapasitas acara harus diisi.',
            'capacity.integer' => 'Kapasitas acara harus berupa angka.',
            'capacity.min' => 'Kapasitas acara harus minimal 1.',
        ];
    }
}
