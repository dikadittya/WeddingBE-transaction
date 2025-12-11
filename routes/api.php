<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterController;

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
    Route::prefix('item-paket')->group(function () {
        Route::get('/', [MasterController::class, 'listMasterItemPaket']);
        Route::post('/', [MasterController::class, 'storeMasterItemPaket']);
        Route::get('/{id}', [MasterController::class, 'listMasterItemPaketDetail']);
        Route::delete('/{id}', [MasterController::class, 'deleteMasterItemPaket']);
    });
});
