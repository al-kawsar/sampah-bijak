<?php

namespace App\Http\Requests\Dashboard\FAQ;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Anda bisa menambahkan logika otorisasi sesuai kebutuhan
    }

    /**
     * Tentukan aturan validasi untuk request ini.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order_number' => 'required|integer|unique:f_a_q_s,order_number',
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
            'question.required' => 'Pertanyaan wajib diisi.',
            'answer.required' => 'Jawaban wajib diisi.',
            'order_number.required' => 'Nomor urutan wajib diisi.',
            'order_number.unique' => 'Nomor urutan sudah digunakan.',
        ];
    }
}
