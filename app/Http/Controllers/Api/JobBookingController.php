<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobBooking;
use App\Models\RegDistricts;
use App\Models\RegRegencies;
use App\Models\RegProvinces;
use App\Http\Requests\JobBookingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = JobBooking::with('creator');

            // Filter by jenis_job if provided
            if ($request->has('jenis_job')) {
                $query->where('jenis_job', $request->jenis_job);
            }

            // Filter by tanggal_job range
            if ($request->has('tanggal_dari')) {
                $query->whereDate('tanggal_job', '>=', $request->tanggal_dari);
            }
            if ($request->has('tanggal_sampai')) {
                $query->whereDate('tanggal_job', '<=', $request->tanggal_sampai);
            }

            // Search by nama_catin
            if ($request->has('search')) {
                $query->where('nama_catin', 'like', '%' . $request->search . '%');
            }

            // Order by tanggal_job descending
            $query->orderBy('tanggal_job', 'desc');

            $jobBookings = $query->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $jobBookings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobBookingRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->check() ? auth()->user()->id : null;
            
            // Populate address fields from IDs
            if (!empty($data['alamat_kec_id'])) {
                $district = RegDistricts::find($data['alamat_kec_id']);
                $data['alamat_kec'] = $district ? $district->name : null;
            }
            if (!empty($data['alamat_kab_id'])) {
                $regency = RegRegencies::find($data['alamat_kab_id']);
                $data['alamat_kab'] = $regency ? $regency->name : null;
            }
            if (!empty($data['alamat_prov_id'])) {
                $province = RegProvinces::find($data['alamat_prov_id']);
                $data['alamat_prov'] = $province ? $province->name : null;
            }
            
            $jobBooking = JobBooking::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Job booking created successfully',
                'data' => $jobBooking->load('creator')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create job booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $jobBooking = JobBooking::with('creator')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $jobBooking
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Job booking not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobBookingRequest $request, string $id): JsonResponse
    {
        try {
            $jobBooking = JobBooking::findOrFail($id);
            $data = $request->validated();
            
            // Populate address fields from IDs
            if (!empty($data['alamat_kec_id'])) {
                $district = RegDistricts::find($data['alamat_kec_id']);
                $data['alamat_kec'] = $district ? $district->name : null;
            }
            if (!empty($data['alamat_kab_id'])) {
                $regency = RegRegencies::find($data['alamat_kab_id']);
                $data['alamat_kab'] = $regency ? $regency->name : null;
            }
            if (!empty($data['alamat_prov_id'])) {
                $province = RegProvinces::find($data['alamat_prov_id']);
                $data['alamat_prov'] = $province ? $province->name : null;
            }
            
            $jobBooking->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Job booking updated successfully',
                'data' => $jobBooking->load('creator')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update job booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $jobBooking = JobBooking::findOrFail($id);
            $jobBooking->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Job booking deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete job booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
