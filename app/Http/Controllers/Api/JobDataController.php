<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobDataRequest;
use App\Models\JobBooking;
use App\Models\JobDataPengantin;
use App\Models\JobDataPaket;
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
            ];
            $jobDataPaket = JobDataPaket::create($dataPaket);

            // Update JobBooking status to 1 (Belum Tuntas)
            $jobBooking = JobBooking::findOrFail($idJobBooking);
            $jobBooking->update(['status_job' => JobBooking::STATUS_BELUM_TUNTAS]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Job data created successfully',
                'data' => [
                    'job_booking' => $jobBooking->load('creator'),
                    'job_data_pengantin' => $jobDataPengantin,
                    'job_data_paket' => $jobDataPaket,
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