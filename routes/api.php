<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\NotaController;
use App\Http\Controllers\API\NotaDetailController;
use App\Http\Controllers\API\StokController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// validasiapi

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::group(['middleware' => ['validasiapi'] ], function()
{
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::post('/kategori', [KategoriController::class, 'store']);
    Route::get('/kategori/{id}', [KategoriController::class, 'edit']);
    Route::put('/kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);

    Route::get('/stok/{kategori_id}', [StokController::class, 'index']);
    Route::post('/stok', [StokController::class, 'store']);
    Route::get('/stok/edit/{id}', [StokController::class, 'edit']);
    Route::put('/stok/{id}', [StokController::class, 'update']);
    Route::delete('/stok/{id}', [StokController::class, 'destroy']);

    Route::get('/nota', [NotaController::class, 'index']);
    Route::post('/nota', [NotaController::class, 'store']);
    Route::get('/nota/{id}', [NotaController::class, 'edit']);
    Route::put('/nota/{id}', [NotaController::class, 'update']);
    Route::delete('/nota/{id}', [NotaController::class, 'destroy']);

    Route::get('/nota-detail/{nota_id}', [NotaDetailController::class, 'index']);
    Route::post('/nota-detail', [NotaDetailController::class, 'store']);
    Route::get('/nota-detail/edit/{id}', [NotaDetailController::class, 'edit']);
    Route::put('/nota-detail/{id}', [NotaDetailController::class, 'update']);
    Route::delete('/nota-detail/{id}', [NotaDetailController::class, 'destroy']);

    
});