<?php

namespace App\Http\Requests\Dashboard\WasteLocation;

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
            'name' => 'required|string|max:255',
            'type' => 'required|in:TPS,TPA,Bank Sampah,Pusat Daur Ulang,Tempat Pengolahan Sampah Organik,Tempat Pembuangan Limbah Berbahaya',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'capacity' => 'required|numeric|min:0',
            'contact_number' => 'required|string|max:15',
        ];
    }

    /**
     * Get the validation messages in Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lokasi wajib diisi.',
            'name.string' => 'Nama lokasi harus berupa teks.',
            'name.max' => 'Nama lokasi tidak boleh lebih dari 255 karakter.',
            'type.required' => 'Jenis lokasi wajib dipilih.',
            'type.in' => 'Jenis lokasi tidak valid.',
            'address.required' => 'Alamat lokasi wajib diisi.',
            'address.string' => 'Alamat lokasi harus berupa teks.',
            'address.max' => 'Alamat lokasi tidak boleh lebih dari 500 karakter.',
            'latitude.required' => 'Koordinat latitude wajib diisi.',
            'latitude.numeric' => 'Koordinat latitude harus berupa angka.',
            'latitude.between' => 'Koordinat latitude harus berada dalam rentang -90 hingga 90.',
            'longitude.required' => 'Koordinat longitude wajib diisi.',
            'longitude.numeric' => 'Koordinat longitude harus berupa angka.',
            'longitude.between' => 'Koordinat longitude harus berada dalam rentang -180 hingga 180.',
            'capacity.required' => 'Kapasitas lokasi wajib diisi.',
            'capacity.numeric' => 'Kapasitas lokasi harus berupa angka.',
            'capacity.min' => 'Kapasitas lokasi tidak boleh negatif.',
            'contact_number.required' => 'Nomor kontak wajib diisi.',
            'contact_number.string' => 'Nomor kontak harus berupa teks.',
            'contact_number.max' => 'Nomor kontak tidak boleh lebih dari 15 karakter.',
        ];
    }
}
