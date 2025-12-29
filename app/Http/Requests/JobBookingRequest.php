<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobBookingRequest extends FormRequest
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
            'tanggal_job' => 'required|date',
            'jenis_job' => 'required|in:wd,rs',
            'nilai_dp' => 'required|numeric|min:0',
            'nama_catin' => 'required|string|max:255',
            'alamat_desa' => 'nullable|string|max:255',
            'alamat_kec_id' => 'nullable|integer|exists:reg_districts,id',
            'alamat_kab_id' => 'nullable|integer|exists:reg_regencies,id',
            'alamat_prov_id' => 'nullable|integer|exists:reg_provinces,id',
            'keterangan' => 'nullable|string',
        ];

        // For update operations, make fields optional with 'sometimes'
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'tanggal_job' => 'sometimes|required|date',
                'jenis_job' => 'sometimes|required|in:wd,rs',
                'nilai_dp' => 'sometimes|required|numeric|min:0',
                'nama_catin' => 'sometimes|required|string|max:255',
                'alamat_desa' => 'nullable|string|max:255',
                'alamat_kec_id' => 'nullable|integer|exists:reg_districts,id',
                'alamat_kab_id' => 'nullable|integer|exists:reg_regencies,id',
                'alamat_prov_id' => 'nullable|integer|exists:reg_provinces,id',
                'keterangan' => 'nullable|string',
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
            'tanggal_job.required' => 'Tanggal job wajib diisi',
            'tanggal_job.date' => 'Tanggal job harus berformat tanggal yang valid',
            'jenis_job.required' => 'Jenis job wajib diisi',
            'jenis_job.in' => 'Jenis job harus wd (wedding) atau rs (resepsi)',
            'nilai_dp.required' => 'Nilai DP wajib diisi',
            'nilai_dp.numeric' => 'Nilai DP harus berupa angka',
            'nilai_dp.min' => 'Nilai DP tidak boleh negatif',
            'nama_catin.required' => 'Nama calon pengantin wajib diisi',
            'nama_catin.max' => 'Nama calon pengantin maksimal 255 karakter',
        ];
    }
}
