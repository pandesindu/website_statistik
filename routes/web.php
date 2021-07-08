<?php

use App\Http\Controllers\Berkelompok;
use App\Http\Controllers\ChiKuadrat;
use App\Http\Controllers\Liliefors;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PointBiserialController;
use App\Http\Controllers\ProdukMomentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded
 by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('depan');
});

Route::get('/profil', function () {
    return view('profil');
});
//Route::get('/', [NilaiController::class, 'index']);
Route::resource('nilai', NilaiController::class);
//Route::get('/export', 'NilaiController@exportnilai')->name('exportnilai');
Route::get('/export', [NilaiController::class, 'exportnilai'])->name('exportnilai');
Route::post('/import', [NilaiController::class, 'importnilai'])->name('importnilai');

Route::patch('/delete', [NilaiController::class, 'delete']);

Route::get('/bergolong', [Berkelompok::class, 'databergolong']);
Route::get('/chi', [ChiKuadrat::class, 'chikuadrat']);
Route::get('/liliefors', [Liliefors::class, 'lilliefors']);

Route::resource('produkmoment', ProdukMomentController::class);
Route::get('/export', [ProdukMomentController::class, 'exportnilai'])->name('exportnilai');
Route::post('/import', [ProdukMomentController::class, 'importnilai'])->name('importnilai');


Route::resource('pointbiserial', PointBiserialController::class);
Route::get('/export', [PointBiserialController::class, 'exportnilai'])->name('exportnilai');
Route::post('/import', [PointBiserialController::class, 'importnilai'])->name('importnilai');