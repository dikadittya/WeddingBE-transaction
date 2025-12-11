<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterMua;
use App\Models\MasterItemPaket;
use App\Models\MasterJenisItemPaket;
use App\Http\Requests\MasterItemPaketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    /**
     * Get list of MasterMua for dropdown
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMasterMua()
    {
        try {
            $masterMua = MasterMua::select('id', 'nama_mua', 'is_vendor')
                ->orderBy('nama_mua', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $masterMua
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of MasterJenisItemPaket for dropdown
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMasterJenisItemPaket()
    {
        try {
            $masterJenisItemPaket = MasterJenisItemPaket::select('id', 'nama_jenis', 'deskripsi')
                ->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $masterJenisItemPaket
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of MasterItemPaket for dropdown with optional filters
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMasterItemPaket(Request $request)
    {
        try {
            $query = MasterItemPaket::select('id', 'nama_item', 'kategori_paket', 'tipe', 'id_jenis')
                ->with('jenisItemPaket:id,nama_jenis');

            // Apply filters if provided
            if ($request->has('nama_item') && $request->nama_item != '') {
                $query->where('nama_item', 'like', '%' . $request->nama_item . '%');
            }

            if ($request->has('kategori_paket') && $request->kategori_paket != '') {
                $query->where('kategori_paket', $request->kategori_paket);
            }

            if ($request->has('tipe') && $request->tipe != '') {
                $query->where('tipe', $request->tipe);
            }

            if ($request->has('id_jenis') && $request->id_jenis != '') {
                $query->where('id_jenis', $request->id_jenis);
            }

            $masterItemPaket = $query->orderBy('id', 'asc')->get();

            return response()->json([
                'success' => true,
                'data' => $masterItemPaket
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Get detailed list of MasterItemPaket including jenis item paket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMasterItemPaketDetail($id)
    {
        try {
            $masterItemPaket = MasterItemPaket::select('id', 'nama_item', 'kategori_paket', 'tipe', 'id_jenis')
                ->with('jenisItemPaket:id,nama_jenis')
                ->orderBy('id', 'asc')
                ->where('id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'data' => $masterItemPaket
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store MasterItemPaket with automatic handling of nama_jenis
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMasterItemPaket(MasterItemPaketRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Check if nama_jenis already exists in MasterJenisItemPaket
            $jenisItemPaket = MasterJenisItemPaket::where('nama_jenis', $request->nama_jenis)->first();
            
            // If not exists, create new MasterJenisItemPaket
            if (!$jenisItemPaket) {
                $jenisItemPaket = MasterJenisItemPaket::create([
                    'nama_jenis' => $request->nama_jenis,
                    'deskripsi' => null
                ]);
            }

            // Check if combination already exists
            $exists = MasterItemPaket::where('id_jenis', $jenisItemPaket->id)
                ->where('nama_item', $request->nama_item)
                ->where('kategori_paket', $request->kategori_paket)
                ->exists();
            
            if ($exists) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Kombinasi jenis item, nama item, dan kategori paket sudah ada.',
                    'errors' => [
                        'nama_item' => ['Kombinasi jenis item, nama item, dan kategori paket sudah ada.']
                    ]
                ], 422);
            }

            // Create MasterItemPaket with id_jenis from MasterJenisItemPaket
            $masterItemPaket = MasterItemPaket::create([
                'id_jenis' => $jenisItemPaket->id,
                'nama_item' => $request->nama_item,
                'kategori_paket' => $request->kategori_paket,
                'tipe' => $request->tipe
            ]);

            // Load the relationship for response
            $masterItemPaket->load('jenisItemPaket:id,nama_jenis');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Master Item Paket berhasil disimpan',
                'data' => $masterItemPaket
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of MasterJenisItemPaket with related MasterItemPaket
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMasterJenisItemPaketWithItems(Request $request)
    {
        try {
            $masterJenisItemPaket = MasterJenisItemPaket::select('id', 'nama_jenis')
                ->with(['itemPakets' => function($query) use ($request) {
                    $query->select('id', 'id_jenis', 'nama_item', 'kategori_paket', 'tipe');
                          
                    if ($request->has('kategori_paket') && $request->kategori_paket != '') {
                        $query->where('kategori_paket', $request->kategori_paket);
                    }
                    $query = $query->orderBy('id', 'asc');
                }])
                ->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $masterJenisItemPaket
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete MasterItemPaket by ID
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMasterItemPaket($id)
    {
        try {
            // Find the MasterItemPaket
            $masterItemPaket = MasterItemPaket::find($id);
            
            if (!$masterItemPaket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Master Item Paket tidak ditemukan'
                ], 404);
            }

            // Delete the record
            $masterItemPaket->delete();

            return response()->json([
                'success' => true,
                'message' => 'Master Item Paket berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}