<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest
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
            'mapel_id' => ['required', 'exists:mapels,id'],
            'semester' => ['required', 'in:1,2'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'nilai' => ['required', 'array', 'min:1'],
            'nilai.*.nilai_tugas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.nilai_uts' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.nilai_uas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.capaian_kompetensi' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Custom validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kelas_id.required' => 'Rombel kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'mapel_id.required' => 'Mata pelajaran wajib dipilih.',
            'mapel_id.exists' => 'Mata pelajaran tidak ditemukan.',
            'semester.required' => 'Semester wajib dipilih.',
            'semester.in' => 'Semester harus bernilai 1 (Ganjil) atau 2 (Genap).',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'nilai.required' => 'Daftar nilai siswa tidak boleh kosong.',
            'nilai.*.nilai_tugas.numeric' => 'Nilai Tugas harus berupa angka.',
            'nilai.*.nilai_tugas.min' => 'Nilai Tugas minimal 0.',
            'nilai.*.nilai_tugas.max' => 'Nilai Tugas maksimal 100.',
            'nilai.*.nilai_uts.numeric' => 'Nilai UTS harus berupa angka.',
            'nilai.*.nilai_uts.min' => 'Nilai UTS minimal 0.',
            'nilai.*.nilai_uts.max' => 'Nilai UTS maksimal 100.',
            'nilai.*.nilai_uas.numeric' => 'Nilai UAS harus berupa angka.',
            'nilai.*.nilai_uas.min' => 'Nilai UAS minimal 0.',
            'nilai.*.nilai_uas.max' => 'Nilai UAS maksimal 100.',
        ];
    }
}
