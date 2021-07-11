<?php

use App\Http\Controllers\Berkelompok;
use App\Http\Controllers\ChiKuadrat;
use App\Http\Controllers\Liliefors;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PointBiserialController;
use App\Http\Controllers\ProdukMomentController;
use App\Http\Controllers\UjiAnavaController;
use App\Http\Controllers\UjiTController;
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

Route::resource('nilai', NilaiController::class);
Route::get('/export', [NilaiController::class, 'exportnilai'])->name('exportnilai');
Route::post('/import', [NilaiController::class, 'importnilai'])->name('importnilai');
Route::patch('/delete', [NilaiController::class, 'delete']);

Route::get('/bergolong', [Berkelompok::class, 'databergolong']);
Route::get('/chi', [ChiKuadrat::class, 'chikuadrat']);
Route::get('/liliefors', [Liliefors::class, 'lilliefors']);


Route::resource('produkmoment', ProdukMomentController::class);
Route::get('/exportProdukMoment', [ProdukMomentController::class, 'exportnilai'])->name('exportMoment');
Route::post('/importProdukMoment', [ProdukMomentController::class, 'importnilai'])->name('importMoment');


Route::resource('pointbiserial', PointBiserialController::class);
Route::get('/exportPointBiserial', [PointBiserialController::class, 'exportnilai'])->name('exportBiserial');
Route::post('/importPointBiserial', [PointBiserialController::class, 'importnilai'])->name('importBiserial');

Route::resource('ujit', UjiTController::class);
Route::get('/exportUjiT', [UjiTController::class, 'exportnilai'])->name('exportUJiT');
Route::post('/importUjiT', [UjiTController::class, 'importnilai'])->name('importUjiT');


Route::resource('anava', UjiAnavaController::class);
Route::get('/exportAnava', [UjiAnavaController::class, 'exportnilai'])->name('exportAnava');
Route::post('/importAnava', [UjiAnavaController::class, 'importnilai'])->name('importAnava');