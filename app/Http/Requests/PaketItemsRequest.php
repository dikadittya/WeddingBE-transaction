<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaketItemsRequest extends FormRequest
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
            'id_paket_master' => 'required|exists:paket_master,id',
            'id_master_item_paket' => 'required|exists:master_item_paket,id',
            'volume' => 'nullable|numeric',
            'harga' => 'nullable|numeric',
        ];

        // For update operations, make fields optional with 'sometimes'
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'id_paket_master' => 'sometimes|required|exists:paket_master,id',
                'id_master_item_paket' => 'sometimes|required|exists:master_item_paket,id',
                'volume' => 'nullable|numeric',
                'harga' => 'nullable|numeric',
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
            'id_paket_master.required' => 'ID Paket Master wajib diisi',
            'id_paket_master.exists' => 'Paket Master yang dipilih tidak valid',
            'id_master_item_paket.required' => 'ID Master Item Paket wajib diisi',
            'id_master_item_paket.exists' => 'Master Item Paket yang dipilih tidak valid',
        ];
    }
}