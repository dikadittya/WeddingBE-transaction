<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobDataRequest extends FormRequest
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
            'id_job_booking' => 'required|exists:job_booking,id',
            
            // JobDataPengantin fields
            'nama_mua' => 'nullable|string|max:255',
            'waktu_job' => 'nullable|in:p,s,m',
            'waktu_job_jam' => 'nullable|date_format:H:i:s',
            'waktu_temu' => 'nullable|in:p,s,m',
            'waktu_temu_jam' => 'nullable|date_format:H:i:s',
            'waktu_resepsi' => 'nullable|in:p,s,m',
            'waktu_resepsi_jam' => 'nullable|date_format:H:i:s',
            'no_hp' => 'nullable|string|max:255',
            'medsos' => 'nullable|string|max:255',
            'alamat_resepsi' => 'nullable|string',
            'alamat_akad' => 'nullable|string',
            'petunjuk_arah' => 'nullable|string',
            'url_map_resepsi' => 'nullable|string|max:255',
            'url_map_akad' => 'nullable|string|max:255',
            'nama_ortu' => 'nullable|string|max:255',
            
            // JobDataPaket fields
            'tambahan_dp' => 'nullable|numeric|min:0',
            'nilai_paket' => 'nullable|numeric|min:0',
            'nilai_dp' => 'nullable|numeric|min:0',
            'nilai_tambahan_item' => 'nullable|numeric|min:0',
            'sisa_bayar' => 'nullable|numeric|min:0',
            'catatan_paket' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id_job_booking.required' => 'ID Job Booking wajib diisi',
            'id_job_booking.exists' => 'ID Job Booking tidak ditemukan',
            'waktu_job.in' => 'Waktu job harus p (pagi), s (siang), atau m (malam)',
            'waktu_temu.in' => 'Waktu temu harus p (pagi), s (siang), atau m (malam)',
            'waktu_resepsi.in' => 'Waktu resepsi harus p (pagi), s (siang), atau m (malam)',
            'waktu_job_jam.date_format' => 'Format waktu job jam harus H:i:s',
            'waktu_temu_jam.date_format' => 'Format waktu temu jam harus H:i:s',
            'waktu_resepsi_jam.date_format' => 'Format waktu resepsi jam harus H:i:s',
        ];
    }
}
