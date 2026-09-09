<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
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
            'kelas_id' => ['required', 'exists:kelas,id'],
            'tanggal' => ['required', 'date'],
            'absensi' => ['required', 'array', 'min:1'],
            'absensi.*.status' => ['required', 'in:H,I,S,A'],
            'absensi.*.keterangan' => ['nullable', 'string', 'max:255'],
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
            'kelas_id.required' => 'Rombel kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal presensi wajib diisi.',
            'absensi.required' => 'Daftar presensi siswa tidak boleh kosong.',
            'absensi.*.status.in' => 'Status kehadiran harus salah satu dari: Hadir (H), Izin (I), Sakit (S), atau Alpa (A).',
        ];
    }
}
