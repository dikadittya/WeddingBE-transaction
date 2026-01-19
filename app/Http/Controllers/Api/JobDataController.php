<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobDataRequest;
use App\Models\JobBooking;
use App\Models\JobDataPengantin;
use App\Models\JobDataPaket;
use App\Models\JobDataMakeup;
use App\Models\JobDataItemPendamping;
use App\Models\JobDataItemDekorasi;
use App\Models\JobDataItemDokumentasi;
use App\Models\JobDataItemEntertain;
use App\Models\JobDataItemProperty;
use App\Models\JobDataItemLain;
use App\Models\JobDataItemTambah;
use App\Models\JobDataNoted;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class JobDataController extends Controller
{
    /**
     * Store job data (pengantin + paket) and update job booking status
     */
    public function store(JobDataRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $idJobBooking = $request->id_job_booking;
            $createdBy = auth()->check() ? auth()->user()->id : null;

            $jobBooking = JobBooking::findOrFail($idJobBooking);
            if(!$jobBooking) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Job booking not found'
                ], 404);
            }
            // Create JobDataPengantin
            $dataPengantin = [
                'id_job_booking' => $idJobBooking,
                'nama_mua' => $request->nama_mua,
                'created_by' => $createdBy,
                'waktu_job' => $request->waktu_job,
                'waktu_job_jam' => $request->waktu_job_jam,
                'waktu_temu' => $request->waktu_temu,
                'waktu_temu_jam' => $request->waktu_temu_jam,
                'waktu_resepsi' => $request->waktu_resepsi,
                'waktu_resepsi_jam' => $request->waktu_resepsi_jam,
                'no_hp' => $request->no_hp,
                'medsos' => $request->medsos,
                'alamat_resepsi' => $request->alamat_resepsi,
                'alamat_akad' => $request->alamat_akad,
                'petunjuk_arah' => $request->petunjuk_arah,
                'url_map_resepsi' => $request->url_map_resepsi,
                'url_map_akad' => $request->url_map_akad,
                'nama_ortu' => $request->nama_ortu,
            ];
            $jobDataPengantin = JobDataPengantin::create($dataPengantin);

            // Create JobDataPaket
            $dataPaket = [
                'id_job_booking' => $idJobBooking,
                'tambahan_dp' => $request->tambahan_dp ?? 0,
                'nilai_paket' => $request->nilai_paket ?? 0,
                'nilai_dp' => $request->nilai_dp ?? 0,
                'nilai_tambahan_item' => $request->nilai_tambahan_item ?? 0,
                'sisa_bayar' => $request->sisa_bayar ?? 0,
                'catatan_paket' => $request->catatan_paket,
                'set_pendamping' => $request->set_pendamping,
                'dekorasi_kode' => $request->dekorasi_kode,
                'dekorasi_tw' => $request->dekorasi_tw,
                'dekorasi_admin' => $request->dekorasi_admin,
            ];
            $jobDataPaket = JobDataPaket::create($dataPaket);

            // Create JobDataMakeup
            $dataMakeup = [
                'id_job_booking' => $idJobBooking,
                'jenis_makeup' => $request->jenis_makeup,
                'busana_akad_perempuan' => $request->busana_akad_perempuan,
                'busana_akad_laki' => $request->busana_akad_laki,
                'busana_temu_perempuan' => $request->busana_temu_perempuan,
                'busana_temu_laki' => $request->busana_temu_laki,
                'busana_ganti_perempuan' => $request->busana_ganti_perempuan,
                'busana_ganti_laki' => $request->busana_ganti_laki,
                'bunga_melati' => $request->bunga_melati,
                'catatan_makeup' => $request->catatan_makeup,
                'mua_nikah' => $request->mua_nikah,
                'mua_resepsi' => $request->mua_resepsi,
                'asisten_nikah' => $request->asisten_nikah,
                'asisten_resepsi' => $request->asisten_resepsi,
                // 'tambahan_gown' => $request->tambahan_gown,
            ];
            $jobDataMakeup = JobDataMakeup::create($dataMakeup);

            // Create JobDataItemPendamping (multiple items)
            $jobDataItemPendampings = [];
            if ($request->has('item_pendampings') && is_array($request->item_pendampings)) {
                foreach ($request->item_pendampings as $itemPendamping) {
                    $dataItemPendamping = [
                        'id_job_booking' => $idJobBooking,
                        'item_pendamping' => $itemPendamping['item_pendamping'] ?? null,
                        'volume' => $itemPendamping['volume'] ?? null,
                        'crew_pendamping' => $itemPendamping['crew_pendamping'] ?? null,
                    ];
                    $jobDataItemPendampings[] = JobDataItemPendamping::create($dataItemPendamping);
                }
            }

            // Create JobDataItemDekorasi (multiple items)
            $jobDataItemDekorasis = [];
            if ($request->has('item_dekorasis') && is_array($request->item_dekorasis)) {
                foreach ($request->item_dekorasis as $itemDekorasi) {
                    $dataItemDekorasi = [
                        'id_job_booking' => $idJobBooking,
                        'item_dekorasi' => $itemDekorasi['item_dekorasi'] ?? null,
                    ];
                    $jobDataItemDekorasis[] = JobDataItemDekorasi::create($dataItemDekorasi);
                }
            }

            // Create JobDataItemDokumentasi (multiple items)
            $jobDataItemDokumentasis = [];
            if ($request->has('item_dokumentasis') && is_array($request->item_dokumentasis)) {
                foreach ($request->item_dokumentasis as $itemDokumentasi) {
                    $dataItemDokumentasi = [
                        'id_job_booking' => $idJobBooking,
                        'item_dokumentasi' => $itemDokumentasi['item_dokumentasi'] ?? null,
                        'volume' => $itemDokumentasi['volume'] ?? 0,
                        'dokumentasi_tw' => $itemDokumentasi['dokumentasi_tw'] ?? null,
                        'dokumentasi_admin' => $itemDokumentasi['dokumentasi_admin'] ?? null,
                    ];
                    $jobDataItemDokumentasis[] = JobDataItemDokumentasi::create($dataItemDokumentasi);
                }
            }

            // Create JobDataItemEntertain (multiple items)
            $jobDataItemEntertains = [];
            if ($request->has('item_entertains') && is_array($request->item_entertains)) {
                foreach ($request->item_entertains as $itemEntertain) {
                    $dataItemEntertain = [
                        'id_job_booking' => $idJobBooking,
                        'item_entertain' => $itemEntertain['item_entertain'] ?? null,
                        'volume' => $itemEntertain['volume'] ?? 0,
                        'entertain_tw' => $itemEntertain['entertain_tw'] ?? null,
                        'entertain_admin' => $itemEntertain['entertain_admin'] ?? null,
                    ];
                    $jobDataItemEntertains[] = JobDataItemEntertain::create($dataItemEntertain);
                }
            }

            // Create JobDataItemProperty (multiple items)
            $jobDataItemProperties = [];
            if ($request->has('item_properties') && is_array($request->item_properties)) {
                foreach ($request->item_properties as $itemProperty) {
                    $dataItemProperty = [
                        'id_job_booking' => $idJobBooking,
                        'item_property' => $itemProperty['item_property'] ?? null,
                        'volume' => $itemProperty['volume'] ?? 0,
                        'satuan' => $itemProperty['satuan'] ?? null,
                        'property_tw' => $itemProperty['property_tw'] ?? null,
                        'property_admin' => $itemProperty['property_admin'] ?? null,
                    ];
                    $jobDataItemProperties[] = JobDataItemProperty::create($dataItemProperty);
                }
            }

            // Create JobDataItemLain (multiple items)
            $jobDataItemLains = [];
            if ($request->has('item_lains') && is_array($request->item_lains)) {
                foreach ($request->item_lains as $itemLain) {
                    $dataItemLain = [
                        'id_job_booking' => $idJobBooking,
                        'item_lain' => $itemLain['item_lain'] ?? null,
                        'volume' => $itemLain['volume'] ?? 0,
                        'satuan' => $itemLain['satuan'] ?? null,
                        'lain_tw' => $itemLain['lain_tw'] ?? null,
                        'lain_admin' => $itemLain['lain_admin'] ?? null,
                    ];
                    $jobDataItemLains[] = JobDataItemLain::create($dataItemLain);
                }
            }

            // Create JobDataItemTambah (multiple items)
            $jobDataItemTambahs = [];
            if ($request->has('item_tambahs') && is_array($request->item_tambahs)) {
                foreach ($request->item_tambahs as $itemTambah) {
                    $dataItemTambah = [
                        'id_job_booking' => $idJobBooking,
                        'item_tambah' => $itemTambah['item_tambah'] ?? null,
                        'nilai' => $itemTambah['nilai'] ?? 0,
                    ];
                    $jobDataItemTambahs[] = JobDataItemTambah::create($dataItemTambah);
                }
            }

            // Create JobDataNoted - Keterangan (multiple items)
            $jobDataNoteds = [];
            if ($request->has('keterangan') && is_array($request->keterangan)) {
                foreach ($request->keterangan as $keterangan) {
                    $dataNoted = [
                        'id_job_booking' => $idJobBooking,
                        'tipe_noted' => 'keterangan',
                        'isi_noted' => $keterangan['isi_noted'] ?? null,
                    ];
                    $jobDataNoteds[] = JobDataNoted::create($dataNoted);
                }
            }

            // Create JobDataNoted - Catatan (multiple items)
            if ($request->has('catatan') && is_array($request->catatan)) {
                foreach ($request->catatan as $catatan) {
                    $dataNoted = [
                        'id_job_booking' => $idJobBooking,
                        'tipe_noted' => 'catatan',
                        'isi_noted' => $catatan['isi_noted'] ?? null,
                    ];
                    $jobDataNoteds[] = JobDataNoted::create($dataNoted);
                }
            }

            // Jika form semua sudah dalam kategori
            // tuntas, maka Data Pengantin dikatakan
            // TUNTAS
            $jobBooking = JobBooking::findOrFail($idJobBooking);
            $jobBooking->update(['status_job' => JobBooking::STATUS_TUNTAS]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Job data created successfully',
                'data' => [
                    // 'job_booking' => $jobBooking->load('creator'),
                    // 'job_data_pengantin' => $jobDataPengantin,
                    // 'job_data_paket' => $jobDataPaket,
                    // 'job_data_makeup' => $jobDataMakeup,
                    // 'job_data_item_pendampings' => $jobDataItemPendampings,
                    // 'job_data_item_dekorasis' => $jobDataItemDekorasis,
                    // 'job_data_item_dokumentasis' => $jobDataItemDokumentasis,
                    // 'job_data_item_entertains' => $jobDataItemEntertains,
                    // 'job_data_item_properties' => $jobDataItemProperties,
                    // 'job_data_item_lains' => $jobDataItemLains,
                    // 'job_data_item_tambahs' => $jobDataItemTambahs,
                    // 'job_data_noteds' => $jobDataNoteds,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create job data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}