<?php

use App\Http\Controllers\ArisanController;
use App\Http\Controllers\KelompokArisanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\DetailKelompokController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserArisanController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('map', function () {
		return view('pages.maps');
	})->name('map');
	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');
	// Route::get('table-list', function () {
	Route::resource('peserta', PesertaController::class);
	Route::resource('arisan', ArisanController::class);
	Route::resource('kelompok_arisan', KelompokArisanController::class);

	Route::resource('user_arisan', UserArisanController::class);

	Route::resource('detail_kelompok_arisan', DetailKelompokController::class);
	Route::resource('pembayaran', PembayaranController::class);

	Route::post('upValidasi/{id}', [PembayaranController::class, 'upValidasi'])->name('upValidasi');
	Route::get('showHistory/{id}', [PembayaranController::class, 'showHistory'])->name('showHistory');

	Route::post('gabung/{id}', [UserArisanController::class, 'gabung'])->name('gabung');
	// Route::put('detail_kelompok_arisan/{id}', ['as' => 'detail_kelompok_arisan.upKet', 'uses' => 'App\Http\Controllers\DetailKelompokController@upKet']);
	Route::get('/detail_kelompok_arisan/{id}', [DetailKelompokController::class, 'index'])->name('index');

	Route::get('showById/{id}', [KelompokArisanController::class, 'showById'])->name('showById');
	Route::get('showPesertaId/{id}', [DetailKelompokController::class, 'showPesertaId'])->name('showPesertaId');
	Route::get('showPembayaran/{id}', [DetailKelompokController::class, 'showPembayaran'])->name('showPembayaran');
	// Route::post('store', [KelompokArisanController::class, 'store']);
	// Route::post('update', [KelompokArisanController::class, 'update']);
	// Route::get('Index', [KelompokArisanController::class, 'index']);
	// })->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});