<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('status_aktif')) {
            $this->merge([
                'status_aktif' => $this->boolean('status_aktif'),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $siswaId = $this->route('siswa')?->id ?? $this->route('siswa');

        return [
            'nis' => ['required', 'string', 'max:20', Rule::unique('siswas', 'nis')->ignore($siswaId)],
            'nisn' => ['nullable', 'string', 'max:20', Rule::unique('siswas', 'nisn')->ignore($siswaId)],
            'nama_siswa' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'status_aktif' => ['boolean'],
            'nama_wali' => ['nullable', 'string', 'max:255'],
            'no_hp_wali' => ['nullable', 'string', 'max:25'],
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
            'nis.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'nis.unique' => 'NIS ini sudah terdaftar untuk siswa lain.',
            'nisn.unique' => 'NISN ini sudah terdaftar untuk siswa lain.',
            'nama_siswa.required' => 'Nama lengkap siswa wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'kelas_id.required' => 'Pilihan kelas wajib ditentukan.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid atau belum terdaftar.',
        ];
    }
}
