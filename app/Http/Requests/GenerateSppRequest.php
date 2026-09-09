<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GenerateSppRequest extends FormRequest
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
            'bulan' => ['required', 'string', 'in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember'],
            'tahun' => ['required', 'integer', 'between:2020,2035'],
            'nominal' => ['required', 'numeric', 'min:1000'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
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
            'bulan.required' => 'Bulan tagihan SPP wajib dipilih.',
            'bulan.in' => 'Nama bulan tidak valid.',
            'tahun.required' => 'Tahun tagihan wajib diisi.',
            'nominal.required' => 'Nominal tagihan SPP wajib diisi.',
            'nominal.numeric' => 'Nominal tagihan harus berupa angka valid.',
            'nominal.min' => 'Nominal tagihan minimal Rp 1.000.',
        ];
    }
}
