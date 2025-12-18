<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterMua;
use App\Models\MasterItemPaket;
use App\Models\MasterItemPaketHarga;
use App\Models\MasterJenisItemPaket;
use App\Http\Requests\MasterItemPaketRequest;
use App\Models\PaketItems;
use App\Models\PaketMaster;
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
            $query = MasterItemPaket::select('id', 'nama_item', 'tipe', 'id_jenis')
                ->with('jenisItemPaket:id,nama_jenis');

            // Apply filters if provided
            if ($request->has('nama_item') && $request->nama_item != '') {
                $query->where('nama_item', 'like', '%' . $request->nama_item . '%');
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
            $masterItemPaket = MasterItemPaket::select('id', 'nama_item', 'tipe', 'id_jenis')
                ->with('jenisItemPaket:id,nama_jenis')
                ->with(['harga' => function($query) {
                    $query->select('id', 'id_master_item_paket', 'id_master_mua', 'harga')
                          ->with('masterMua:id,nama_mua');
                }])
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

            // master_item_paket
            // $masterItemPaket = MasterItemPaket::where('id', $request->id_master_item_paket)->first();
            // paket_master
            $paketMaster = PaketMaster::where('id', $request->id_paket)->first();
            // insert master_item_paket_harga
            MasterItemPaketHarga::create([
                'id_paket' => $request->id_paket,
                'id_master_item_paket' => $request->id_master_item_paket,
                'harga' => $request->harga,
                'kategori' => $paketMaster->jenis_paket,
                'id_master_mua' => $paketMaster->id_mua,
            ]);
            // insert paket_items
            PaketItems::create([
                'id_paket_master' => $request->id_paket,
                'id_master_item_paket' => $request->id_master_item_paket,
                'volume' => $request->volume,
            ]);


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => null
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
            $masterJenisItemPaket = MasterJenisItemPaket::select('order_jenis', 'id', 'nama_jenis')
                ->with(['itemPakets' => function($query) use ($request) {
                    $query->select('order_item', 'id', 'id_jenis', 'nama_item', 'tipe');
                    // $query->with(['harga' => function($query) {
                    //     $query->select('id', 'id_master_item_paket', 'id_master_mua', 'harga')
                    //         ->with('masterMua:id,nama_mua');
                    // }]);
                    $query = $query->orderBy('order_item', 'asc');
                }])
                ->orderBy('order_jenis', 'asc')
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

    /**
     * Get master item paket harga with mua and paket master data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMasterItemPaketHargaWithDetails()
    {
        try {
            $data = DB::table('master_item_paket_harga')
                ->leftJoin('master_mua', 'master_item_paket_harga.id_master_mua', '=', 'master_mua.id')
                ->leftJoin('paket_master', function($join) {
                    $join->on('master_item_paket_harga.kategori', '=', 'paket_master.jenis_paket')
                         ->on('paket_master.id_mua', '=', 'master_item_paket_harga.id_master_mua');
                })
                ->select(
                    'master_item_paket_harga.id AS id_master_item_paket_harga',
                    'master_item_paket_harga.id_master_item_paket',
                    'master_item_paket_harga.id_master_mua',
                    'master_item_paket_harga.harga',
                    'master_mua.nama_mua',
                    'master_mua.is_vendor',
                    'paket_master.nama_paket'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

}