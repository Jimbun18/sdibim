<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuruRequest extends FormRequest
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
        $guruId = $this->route('guru')?->id ?? $this->route('guru');

        return [
            'nip' => ['nullable', 'string', 'max:50', Rule::unique('gurus', 'nip')->ignore($guruId)],
            'nama_guru' => ['required', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:25'],
            'email' => ['nullable', 'email', 'max:255'],
            'alamat' => ['nullable', 'string'],
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
            'nama_guru.required' => 'Nama lengkap guru wajib diisi.',
            'nama_guru.max' => 'Nama guru tidak boleh melebihi 255 karakter.',
            'nip.unique' => 'NIP ini sudah terdaftar di sistem.',
            'email.email' => 'Format email guru tidak valid.',
        ];
    }
}
