<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaketItems;
use App\Http\Requests\PaketItemsRequest;
use App\Models\MasterItemPaketHarga;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PaketItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $data = DB::table('master_item_paket')
                ->leftJoin('master_item_paket_harga', 'master_item_paket.id', '=', 'master_item_paket_harga.id_master_item_paket')
                ->leftJoin('master_mua', 'master_item_paket_harga.id_master_mua', '=', 'master_mua.id')
                ->leftJoin('master_jenis_item_paket', 'master_item_paket.id_jenis', '=', 'master_jenis_item_paket.id')
                ->leftJoin('paket_master', function($join) {
                    $join->on('master_item_paket_harga.kategori', '=', 'paket_master.jenis_paket')
                         ->on('paket_master.id_mua', '=', 'master_item_paket_harga.id_master_mua');
                })
                ->select(
                    'master_item_paket.id',
                    'master_item_paket.nama_item',
                    'master_item_paket.tipe',
                    'master_item_paket.order_item',
                    'master_item_paket_harga.harga',
                    'master_item_paket_harga.kategori',
                    'master_item_paket_harga.id_master_mua AS id_mua',
                    'master_item_paket.id_jenis',
                    'master_jenis_item_paket.nama_jenis',
                    'master_mua.nama_mua',
                    'master_mua.is_vendor',
                    'paket_master.id AS id_paket',
                    'paket_master.nama_paket'
                )
                ->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $data
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
    public function store(PaketItemsRequest $request): JsonResponse
    {
        try {
            $masterItemPaket = MasterItemPaketHarga::where('id_master_item_paket', $request->input('id_master_item_paket'))->first();
            $paketItems = PaketItems::create($request->only([
                'id_paket_master',
                'id_master_item_paket',
                'volume'
            ]));

            if ($request->filled('harga')) {
                MasterItemPaketHarga::create([
                    'id_master_item_paket' => $request->input('id_master_item_paket'),
                    'harga' => $request->input('harga'),
                    'kategori' => $masterItemPaket->kategori,
                    'id_master_mua' => $masterItemPaket->id_master_mua
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Paket items created successfully',
                'data' => $paketItems->load('paketMaster', 'masterItemPaket.harga.masterMua')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create paket items',
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
            $paketItems = PaketItems::with('paketMaster', 'masterItemPaket.harga.masterMua')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $paketItems
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paket items not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaketItemsRequest $request, string $id): JsonResponse
    {
        try {
            $paketItems = PaketItems::findOrFail($id);

            $paketItems->update($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Paket items updated successfully',
                'data' => $paketItems->load('paketMaster', 'masterItemPaket.harga.masterMua')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update paket items',
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
            $paketItems = PaketItems::findOrFail($id);
            $paketItems->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Paket items deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete paket items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get paket items by paket master ID.
     */
    public function getByPaketMaster(string $paketMasterId): JsonResponse
    {
        try {
            $paketItems = PaketItems::with('paketMaster', 'masterItemPaket.harga.masterMua')
                ->where('id_paket_master', $paketMasterId)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $paketItems
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