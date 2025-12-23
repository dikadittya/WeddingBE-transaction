<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaketUp;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PaketUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = PaketUp::with('jenisItemPaket');

            // Filter by jenis_up
            if ($request->has('jenis_up')) {
                $query->where('jenis_up', $request->jenis_up);
            }

            // Filter by kode_area
            if ($request->has('kode_area')) {
                $query->byArea($request->kode_area);
            }

            // Filter by id_jenis_item_paket
            if ($request->has('id_jenis_item_paket')) {
                $query->where('id_jenis_item_paket', $request->id_jenis_item_paket);
            }

            $paketUps = $query->orderBy('created_at', 'desc')->get();

            // Transform the data to flatten jenis_item_paket fields
            $transformedData = $paketUps->map(function ($paketUp) {
                return [
                    'id' => $paketUp->id,
                    'jenis_up' => $paketUp->jenis_up,
                    'id_jenis_item_paket' => $paketUp->id_jenis_item_paket,
                    'jenis_item_paket' => $paketUp->jenisItemPaket->nama_jenis ?? null,
                    'order_jenis' => $paketUp->jenisItemPaket->order_jenis ?? null,
                    'kode_area' => $paketUp->kode_area,
                    'nilai_up' => $paketUp->nilai_up,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data paket UP berhasil diambil',
                'data' => $transformedData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data paket UP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'jenis_up' => 'required|in:gedung,rumahan',
                'id_jenis_item_paket' => 'required|integer|exists:master_jenis_item_paket,id',
                'kode_area' => 'required|string|max:20',
                'nilai_up' => 'required|numeric|min:0'
            ]);

            $paketUp = PaketUp::create($validatedData);
            $paketUp->load('jenisItemPaket');

            return response()->json([
                'success' => true,
                'data' => $paketUp
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
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
            $paketUp = PaketUp::with('jenisItemPaket')->findOrFail($id);

            // Transform the data to flatten jenis_item_paket fields
            $transformedData = [
                'id' => $paketUp->id,
                'jenis_up' => $paketUp->jenis_up,
                'id_jenis_item_paket' => $paketUp->id_jenis_item_paket,
                'jenis_item_paket' => $paketUp->jenisItemPaket->nama_jenis ?? null,
                'order_jenis' => $paketUp->jenisItemPaket->order_jenis ?? null,
                'kode_area' => $paketUp->kode_area,
                'nilai_up' => $paketUp->nilai_up,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Detail paket UP berhasil diambil',
                'data' => $transformedData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Paket UP tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $paketUp = PaketUp::findOrFail($id);

            $validatedData = $request->validate([
                'jenis_up' => 'sometimes|required|in:gedung,rumahan',
                'id_jenis_item_paket' => 'sometimes|required|integer|exists:master_jenis_item_paket,id',
                'kode_area' => 'sometimes|required|string|max:20',
                'nilai_up' => 'sometimes|required|numeric|min:0'
            ]);

            $paketUp->update($validatedData);
            $paketUp->load('jenisItemPaket');

            return response()->json([
                'success' => true,
                'message' => 'Paket UP berhasil diupdate',
                'data' => $paketUp
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
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
            $paketUp = PaketUp::findOrFail($id);
            $paketUp->delete();

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get paket UP by jenis (gedung or rumahan).
     */
    public function getByJenis(string $jenis): JsonResponse
    {
        try {
            if (!in_array($jenis, ['gedung', 'rumahan'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jenis tidak valid. Harus gedung atau rumahan'
                ], 400);
            }

            $paketUps = PaketUp::with('jenisItemPaket')
                ->where('jenis_up', $jenis)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => "Data paket UP {$jenis} berhasil diambil",
                'data' => $paketUps
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data paket UP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get paket UP by area.
     */
    public function getByArea(string $kodeArea): JsonResponse
    {
        try {
            $paketUps = PaketUp::with('jenisItemPaket')
                ->byArea($kodeArea)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => "Data paket UP area {$kodeArea} berhasil diambil",
                'data' => $paketUps
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data paket UP',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
