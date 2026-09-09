<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKelasRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_kelas' => ['required', 'string', 'max:50'],
            'tingkat' => ['required', 'integer', 'between:1,6'],
            'wali_kelas_id' => ['nullable', 'exists:gurus,id'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'tingkat.required' => 'Tingkat kelas wajib dipilih.',
            'tingkat.between' => 'Tingkat kelas harus antara 1 sampai 6.',
            'wali_kelas_id.exists' => 'Wali kelas yang dipilih tidak ditemukan dalam data guru.',
        ];
    }
}
