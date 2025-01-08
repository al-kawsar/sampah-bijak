<?php

namespace App\Http\Requests\Dashboard\HomepageSlider;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ganti dengan pengecekan otorisasi sesuai kebutuhan.
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048', // Max 2MB
            'link' => 'nullable|url|max:255',
            'order_number' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul slider harus diisi.',
            'title.string' => 'Judul slider harus berupa teks.',
            'title.max' => 'Judul slider maksimal 255 karakter.',
            'image.required' => 'Gambar slider harus diunggah.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'link.url' => 'Tautan harus berupa URL yang valid.',
            'link.max' => 'Tautan maksimal 255 karakter.',
            'order_number.integer' => 'Nomor urut harus berupa angka.',
            'order_number.min' => 'Nomor urut minimal bernilai 1.',
            'is_active.boolean' => 'Status aktif harus berupa nilai boolean.',
        ];
    }
}
