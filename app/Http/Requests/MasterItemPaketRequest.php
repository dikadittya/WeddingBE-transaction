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
            'id_paket' => 'required|integer',
            'id_master_item_paket' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'volume' => 'required|numeric|min:0'
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
            'id_paket.required' => 'ID Paket harus diisi',
            'id_paket.integer' => 'ID Paket harus berupa angka',
            'id_master_item_paket.required' => 'ID Master Item Paket harus diisi',
            'id_master_item_paket.integer' => 'ID Master Item Paket harus berupa angka',
            'id_master_item_paket.exists' => 'ID Master Item Paket tidak valid',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'volume.required' => 'Volume harus diisi',
            'volume.numeric' => 'Volume harus berupa angka',
            'volume.min' => 'Volume tidak boleh negatif'
        ];
    }
}
