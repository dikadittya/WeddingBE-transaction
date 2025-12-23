<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\PaketMasterController;
use App\Http\Controllers\Api\PaketItemsController;
use App\Http\Controllers\Api\PaketUpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::prefix('master')->group(function () {
    Route::get('mua', [MasterController::class, 'listMasterMua']);
    Route::get('jenis-item-paket', [MasterController::class, 'listMasterJenisItemPaket']);
    Route::get('item-paket-grup', [MasterController::class, 'listMasterJenisItemPaketWithItems']);
    Route::get('harga-paket', [MasterController::class, 'getMasterItemPaketHargaWithDetails']);
    Route::prefix('item-paket')->group(function () {
        Route::get('/', [MasterController::class, 'listMasterItemPaket']);
        Route::post('/', [MasterController::class, 'storeMasterItemPaket']);
        Route::get('/{id}', [MasterController::class, 'listMasterItemPaketDetail']);
        Route::delete('/{id}', [MasterController::class, 'deleteMasterItemPaket']);
    });
});

Route::prefix('paket')->group(function () {
    Route::get('/', [PaketMasterController::class, 'index']);
    Route::post('/', [PaketMasterController::class, 'store']);
    Route::get('/{id}', [PaketMasterController::class, 'show']);
    Route::put('/{id}', [PaketMasterController::class, 'update']);
    Route::delete('/{id}', [PaketMasterController::class, 'destroy']);
    Route::get('/mua/{muaId}', [PaketMasterController::class, 'getByMua']);
    Route::get('/jenis/{jenis}', [PaketMasterController::class, 'getByJenis']);
});

Route::prefix('paket-items')->group(function () {
    Route::get('/', [PaketItemsController::class, 'index']);
    Route::post('/', [PaketItemsController::class, 'store']);
    Route::get('/{id}', [PaketItemsController::class, 'show']);
    Route::put('/{id}', [PaketItemsController::class, 'update']);
    Route::delete('/{id}', [PaketItemsController::class, 'destroy']);
    Route::get('/paket-master/{paketMasterId}', [PaketItemsController::class, 'getByPaketMaster']);
});

Route::prefix('paket-up')->group(function () {
    Route::get('/', [PaketUpController::class, 'index']);
    Route::post('/', [PaketUpController::class, 'store']);
    Route::get('/{id}', [PaketUpController::class, 'show']);
    Route::put('/{id}', [PaketUpController::class, 'update']);
    Route::delete('/{id}', [PaketUpController::class, 'destroy']);
    Route::get('/jenis/{jenis}', [PaketUpController::class, 'getByJenis']);
    Route::get('/area/{kodeArea}', [PaketUpController::class, 'getByArea']);
});