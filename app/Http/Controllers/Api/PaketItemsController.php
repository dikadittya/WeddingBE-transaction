<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaketItems;
use App\Http\Requests\PaketItemsRequest;
use Illuminate\Http\JsonResponse;

class PaketItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $paketItems = PaketItems::with('paketMaster', 'masterItemPaket.harga.masterMua')->get();
            
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaketItemsRequest $request): JsonResponse
    {
        try {
            $paketItems = PaketItems::create($request->validated());

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