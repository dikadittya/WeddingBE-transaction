<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaketMasterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'id_mua' => 'required|exists:master_mua,id',
            'nama_paket' => 'required|string|max:255',
            'jenis_paket' => 'required|in:gedung,rumahan'
        ];

        // For update operations, make fields optional with 'sometimes'
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'id_mua' => 'sometimes|required|exists:master_mua,id',
                'nama_paket' => 'sometimes|required|string|max:255',
                'jenis_paket' => 'sometimes|required|in:gedung,rumahan'
            ];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id_mua.required' => 'ID MUA wajib diisi',
            'id_mua.exists' => 'MUA yang dipilih tidak valid',
            'nama_paket.required' => 'Nama paket wajib diisi',
            'nama_paket.string' => 'Nama paket harus berupa teks',
            'nama_paket.max' => 'Nama paket maksimal 255 karakter',
            'jenis_paket.required' => 'Jenis paket wajib diisi',
            'jenis_paket.in' => 'Jenis paket harus gedung atau rumahan'
        ];
    }
}