<?php

namespace App\Http\Requests\Dashboard\LearningModule;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ganti sesuai kebijakan otorisasi Anda.
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul modul pembelajaran harus diisi.',
            'title.string' => 'Judul modul harus berupa teks.',
            'title.max' => 'Judul modul maksimal 255 karakter.',
            'description.required' => 'Deskripsi modul harus diisi.',
            'description.string' => 'Deskripsi modul harus berupa teks.',
            'content.required' => 'Konten modul harus diisi.',
            'content.string' => 'Konten modul harus berupa teks.',
            'thumbnail.image' => 'Thumbnail harus berupa file gambar.',
            'thumbnail.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
