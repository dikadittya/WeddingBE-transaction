<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaketMaster;
use App\Http\Requests\PaketMasterRequest;
use Illuminate\Http\JsonResponse;

class PaketMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $paketMasters = PaketMaster::with('mua', 'paketItems')->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $paketMasters
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
    public function store(PaketMasterRequest $request): JsonResponse
    {
        try {
            $paketMaster = PaketMaster::create($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Paket master created successfully',
                'data' => $paketMaster->load('mua')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create paket master',
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
            $paketMaster = PaketMaster::with('mua', 'paketItems')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                // 'data' => $paketMaster,
                'data' => [
                    'id' => $paketMaster->id,
                    // 'id_mua' => $paketMaster->id_mua,
                    'nama_paket' => $paketMaster->nama_paket,
                    'jenis_paket' => $paketMaster->jenis_paket,
                    'nama_mua' => $paketMaster->mua->nama_mua,
                    // 'mua' => [
                    //     'id' => $paketMaster->mua->id,
                    //     'nama_mua' => $paketMaster->mua->nama_mua
                    // ],
                    'paket_items' => $paketMaster->paketItems->map(function($item) {
                        return [
                            'id' => $item->id,
                            'id_paket_master' => $item->id_paket_master,
                            'id_master_item_paket' => $item->id_master_item_paket,
                            'nama_item' => $item->masterItemPaket->nama_item,
                            'kategori_paket' => $item->masterItemPaket->kategori_paket,
                            'tipe' => $item->masterItemPaket->tipe,
                            'harga' => $item->masterItemPaket->harga->map(function($harga) {
                                return [
                                    'id' => $harga->id,
                                    'id_master_item_paket' => $harga->id_master_item_paket,
                                    'harga_item' => $harga->harga,
                                    'keterangan' => $harga->keterangan,
                                ];
                            })
                        ];
                    })
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paket master not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaketMasterRequest $request, string $id): JsonResponse
    {
        try {
            $paketMaster = PaketMaster::findOrFail($id);

            $paketMaster->update($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Paket master updated successfully',
                'data' => $paketMaster->load('mua')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update paket master',
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
            $paketMaster = PaketMaster::findOrFail($id);
            $paketMaster->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Paket master deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete paket master',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get paket masters by MUA ID.
     */
    public function getByMua(string $muaId): JsonResponse
    {
        try {
            $paketMasters = PaketMaster::with('mua', 'paketItems')
                ->where('id_mua', $muaId)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $paketMasters
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
     * Get paket masters by jenis paket.
     */
    public function getByJenis(string $jenis): JsonResponse
    {
        try {
            $paketMasters = PaketMaster::with('mua', 'paketItems')
                ->where('jenis_paket', $jenis)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $paketMasters
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}