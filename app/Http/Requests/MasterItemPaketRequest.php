<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterItemPaketRequest extends FormRequest
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
        return [
            'nama_item' => 'required|string|max:255',
            'kategori_paket' => 'required|in:gedung,rumahan',
            'tipe' => 'required|in:reguler,khusus',
            'nama_jenis' => 'required|string|max:255'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nama_item.required' => 'Nama item harus diisi',
            'nama_item.max' => 'Nama item maksimal 255 karakter',
            'kategori_paket.required' => 'Kategori paket harus diisi',
            'kategori_paket.in' => 'Kategori paket harus berupa gedung atau rumahan',
            'tipe.required' => 'Tipe harus diisi',
            'tipe.in' => 'Tipe harus berupa reguler atau khusus',
            'nama_jenis.required' => 'Nama jenis harus diisi',
            'nama_jenis.max' => 'Nama jenis maksimal 255 karakter'
        ];
    }
}
