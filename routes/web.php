<?php

use App\Models\Alat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterControlller;
use App\Http\Controllers\PeminjamanController;

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

// Route::get('/', function () {
//     return view('main');
// })->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->middleware('auth');

//Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/loginuser', [LoginController::class, 'loginuser']);
//Logout
Route::get('/logout', [LoginController::class, 'logout']);

//Register
Route::get('/register', [RegisterControlller::class, 'index']);
Route::post('/registeruser', [RegisterControlller::class, 'store']);

//Alat
Route::get('/alat', [AlatController::class,'index'])->name('alat')->middleware('auth');
Route::get('/alat/add', [AlatController::class, 'add'])->middleware('auth');
Route::post('/alat/add', [AlatController::class, 'store'])->middleware('auth');
Route::get('/alat/{id}', [AlatController::class, 'edit'])->middleware('auth');
Route::post('/edit/{id}', [AlatController::class, 'update'])->middleware('auth');
Route::get('/delete-alat/{id}', [AlatController::class, 'destroy'])->middleware('auth');

//Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman')->middleware('auth');
Route::get('/peminjaman/add', [PeminjamanController::class, 'add'])->middleware('auth');
Route::post('/peminjamanuser', [PeminjamanController::class, 'store'])->middleware('auth');
Route::get('/delete-pinjam/{id}', [PeminjamanController::class, 'destroy'])->middleware('auth');
Route::get('/ubah-status/{id}', [PeminjamanController::class, 'status'])->middleware('auth');
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'edit'])->middleware('auth');
Route::post('/peminjaman-edit/{id}', [PeminjamanController::class, 'update'])->middleware('auth');
