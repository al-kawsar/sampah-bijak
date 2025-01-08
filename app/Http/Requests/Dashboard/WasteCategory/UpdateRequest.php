<?php

namespace App\Http\Requests\Dashboard\WasteCategory;

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

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the validation messages in Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
        ];
    }
}
