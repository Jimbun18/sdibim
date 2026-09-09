<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BayarSppRequest extends FormRequest
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
            'metode_bayar' => ['required', 'string', 'max:50'],
            'tanggal_bayar' => ['required', 'date'],
            'catatan' => ['nullable', 'string', 'max:255'],
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
            'metode_bayar.required' => 'Metode pembayaran (Tunai, Transfer, dll) wajib dipilih.',
            'tanggal_bayar.required' => 'Tanggal pembayaran wajib diisi.',
        ];
    }
}
