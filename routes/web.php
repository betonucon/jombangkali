<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\NonwargaController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\Auth\LogoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
});

Route::group(['prefix' => 'warga','middleware'    => 'auth'],function(){
    Route::get('/',[WargaController::class, 'index']);
    Route::get('/view',[WargaController::class, 'view_data']);
    Route::get('/getdata',[WargaController::class, 'get_data']);
    Route::get('/delete_data',[WargaController::class, 'delete_data']);
    Route::get('/create',[WargaController::class, 'create']);
    Route::get('/modal_foto',[WargaController::class, 'modal_foto']);
    Route::get('/modal',[WargaController::class, 'modal']);
    Route::post('/',[WargaController::class, 'store']);
    Route::post('/upload_ktp',[WargaController::class, 'upload_ktp']);
    Route::post('/import',[WargaController::class, 'import']);
});
Route::group(['prefix' => 'kk','middleware'    => 'auth'],function(){
    Route::get('/',[WargaController::class, 'index_kk']);
    Route::get('/view',[WargaController::class, 'view_data_kk']);
    Route::get('/getdata',[WargaController::class, 'get_data_kk']);
    Route::get('/delete_data',[WargaController::class, 'delete_data_kk']);
    Route::get('/create',[WargaController::class, 'create_kk']);
    Route::get('/modal',[WargaController::class, 'modal_kk']);
    Route::get('/cetak',[WargaController::class, 'cetak_kk']);
    Route::get('/cetak_warga',[WargaController::class, 'cetak_warga']);
    Route::post('/',[WargaController::class, 'store_kk']);
    Route::post('/import',[WargaController::class, 'import_kk']);
});
Route::group(['prefix' => 'nonwarga','middleware'    => 'auth'],function(){
    Route::get('/',[NonwargaController::class, 'index']);
    Route::get('/view',[NonwargaController::class, 'view_data']);
    Route::get('/getdata',[NonwargaController::class, 'get_data']);
    Route::get('/delete_data',[NonwargaController::class, 'delete_data']);
    Route::get('/create',[NonwargaController::class, 'create']);
    Route::get('/modal',[NonwargaController::class, 'modal']);
    Route::post('/',[NonwargaController::class, 'store']);
    Route::post('/import',[NonwargaController::class, 'import']);
});
Route::group(['prefix' => 'keuangan','middleware'    => 'auth'],function(){
    Route::get('/',[KeuanganController::class, 'index']);
    Route::get('/view',[KeuanganController::class, 'view_data']);
    Route::get('/cetak',[KeuanganController::class, 'cetak_data']);
    Route::get('/generateuang',[KeuanganController::class, 'generate']);
    Route::get('/getdata',[KeuanganController::class, 'get_data']);
    Route::get('/delete_data',[KeuanganController::class, 'delete_data']);
    Route::get('/create',[KeuanganController::class, 'create']);
    Route::get('/modal',[KeuanganController::class, 'modal']);
    Route::post('/',[KeuanganController::class, 'store']);
    Route::post('/import',[KeuanganController::class, 'import']);
});
Route::group(['middleware' => 'auth'], function() {
    /**
    * Logout Route
    */
    Route::get('/logout-perform', [LogoutController::class, 'perform'])->name('logout.perform');
 });

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

