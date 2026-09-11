<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMapelRequest extends FormRequest
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
        $mapelId = $this->route('mapel')?->id ?? $this->route('mapel');

        return [
            'kode_mapel' => [
                'required',
                'string',
                'max:20',
                Rule::unique('mapels', 'kode_mapel')->ignore($mapelId),
            ],
            'nama_mapel' => ['required', 'string', 'max:100'],
            'kkm' => ['required', 'integer', 'between:0,100'],
            'guru_id' => ['nullable', 'exists:gurus,id'],
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
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.unique' => 'Kode mata pelajaran sudah digunakan.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
            'kkm.required' => 'Nilai KKM wajib diisi.',
            'kkm.between' => 'Nilai KKM harus berada di rentang 0 sampai 100.',
            'guru_id.exists' => 'Guru pengampu yang dipilih tidak terdaftar di sistem.',
        ];
    }
}
