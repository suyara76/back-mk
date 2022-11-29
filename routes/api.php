<?php

use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\Foto\FotoController;
use App\Http\Controllers\TipoServico\TipoServicoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'auth.jwt',  "throttle:10000,1"], function () {
// });

// ------------------------
// Tipo Servico
// ------------------------
Route::resource ('/tipo-servico', TipoServicoController::class);

Route::resource ('/empresa',                             EmpresaController::class);
Route::post     ('/empresa/vincular-tipo-servico/{id}', [EmpresaController::class, 'vincularTiposServicos']);
Route::post     ('/empresa/upload-foto/{id}', [EmpresaController::class, 'uploadFoto']);
Route::delete   ('/empresa/delete-fotos/{id}', [EmpresaController::class, 'deletarFotosEmpresas']);
Route::get      ('/empresa/carregar-fotos-empresas/{id}', [EmpresaController::class, 'carregarFotosEmpresas']);

Route::post     ('/user/login', [UserController::class, 'login']);
Route::get      ('/user/teste', [UserController::class, 'teste']);
Route::resource ('/user', UserController::class);

Route::resource ('/foto', FotoController::class);
Route::post     ('/foto/upload-logo-empresa/{id}', [FotoController::class, 'uploadLogoEmpresa']);
Route::get      ('/foto/show-logo-empresa/{id}', [FotoController::class, 'logoFindById']);
Route::get      ('/foto/delete-arquivo-empresa/{id}', [FotoController::class, 'deleteArquivoEmpresa']);