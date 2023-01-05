<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
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


Route::group(['prefix' => 'warga','middleware'    => 'auth'],function(){
    Route::get('/',[WargaController::class, 'index']);
    Route::get('/view',[WargaController::class, 'view_data']);
    Route::get('/getdata',[WargaController::class, 'get_data']);
    Route::get('/delete_data',[WargaController::class, 'delete_data']);
    Route::get('/create',[WargaController::class, 'create']);
    Route::get('/modal',[WargaController::class, 'modal']);
    Route::post('/',[WargaController::class, 'store']);
    Route::post('/import',[WargaController::class, 'import']);
});
Route::group(['prefix' => 'keuangan','middleware'    => 'auth'],function(){
    Route::get('/',[KeuanganController::class, 'index']);
    Route::get('/view',[KeuanganController::class, 'view_data']);
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

