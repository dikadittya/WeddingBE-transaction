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
            'set_pendamping' => 'nullable|string|max:255',
            'dekorasi_kode' => 'nullable|string|max:255',
            'dekorasi_tw' => 'nullable|string|max:255',
            'dekorasi_admin' => 'nullable|string|max:255',
            
            // JobDataMakeup fields
            'jenis_makeup' => 'nullable|string|max:255',
            'busana_akad_perempuan' => 'nullable|string|max:255',
            'busana_akad_laki' => 'nullable|string|max:255',
            'busana_temu_perempuan' => 'nullable|string|max:255',
            'busana_temu_laki' => 'nullable|string|max:255',
            'busana_ganti_perempuan' => 'nullable|string|max:255',
            'busana_ganti_laki' => 'nullable|string|max:255',
            'bunga_melati' => 'nullable|string|max:255',
            'catatan_makeup' => 'nullable|string',
            'mua_nikah' => 'nullable|string|max:255',
            'mua_resepsi' => 'nullable|string|max:255',
            'asisten_nikah' => 'nullable|string|max:255',
            'asisten_resepsi' => 'nullable|string|max:255',
            'tambahan_gown' => 'nullable|array',
            'tambahan_gown.*.nama' => 'nullable|string|max:255',
            'tambahan_gown.*.jenis' => 'nullable|string|max:255',
            'tambahan_gown.*.untuk' => 'nullable|string|max:255',
            
            // JobDataItemPendamping fields (array)
            'item_pendampings' => 'nullable|array',
            'item_pendampings.*.item_pendamping' => 'nullable|string|max:255',
            'item_pendampings.*.volume' => 'nullable|integer|min:0',
            'item_pendampings.*.crew_pendamping' => 'nullable|string|max:255',
            
            // JobDataItemDekorasi fields (array)
            'item_dekorasis' => 'nullable|array',
            'item_dekorasis.*.item_dekorasi' => 'nullable|string|max:255',
            
            // JobDataItemDokumentasi fields (array)
            'item_dokumentasis' => 'nullable|array',
            'item_dokumentasis.*.item_dokumentasi' => 'nullable|string|max:255',
            'item_dokumentasis.*.volume' => 'nullable|integer|min:0',
            'item_dokumentasis.*.dokumentasi_tw' => 'nullable|string|max:255',
            'item_dokumentasis.*.dokumentasi_admin' => 'nullable|string|max:255',
            
            // JobDataItemEntertain fields (array)
            'item_entertains' => 'nullable|array',
            'item_entertains.*.item_entertain' => 'nullable|string|max:255',
            'item_entertains.*.volume' => 'nullable|integer|min:0',
            'item_entertains.*.entertain_tw' => 'nullable|string|max:255',
            'item_entertains.*.entertain_admin' => 'nullable|string|max:255',
            
            // JobDataItemProperty fields (array)
            'item_properties' => 'nullable|array',
            'item_properties.*.item_property' => 'nullable|string|max:255',
            'item_properties.*.volume' => 'nullable|integer|min:0',
            'item_properties.*.satuan' => 'nullable|string|max:255',
            'item_properties.*.property_tw' => 'nullable|string|max:255',
            'item_properties.*.property_admin' => 'nullable|string|max:255',
            
            // JobDataItemLain fields (array)
            'item_lains' => 'nullable|array',
            'item_lains.*.item_lain' => 'nullable|string|max:255',
            'item_lains.*.volume' => 'nullable|integer|min:0',
            'item_lains.*.satuan' => 'nullable|string|max:255',
            'item_lains.*.lain_tw' => 'nullable|string|max:255',
            'item_lains.*.lain_admin' => 'nullable|string|max:255',
            
            // JobDataItemTambah fields (array)
            'item_tambahs' => 'nullable|array',
            'item_tambahs.*.item_tambah' => 'nullable|string|max:255',
            'item_tambahs.*.nilai' => 'nullable|numeric|min:0',
            
            // JobDataNoted fields - Keterangan (array)
            'keterangan' => 'nullable|array',
            'keterangan.*.isi_noted' => 'nullable|string',
            
            // JobDataNoted fields - Catatan (array)
            'catatan' => 'nullable|array',
            'catatan.*.isi_noted' => 'nullable|string',
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
