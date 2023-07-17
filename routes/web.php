<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('getBooks', [BookController::class, 'getBooks'])->name('getBooks');
Route::get('bookPagination', [BookController::class, 'bookPagination'])->name('bookPagination');
Route::post('bookPaginationGetBooks', [BookController::class, 'bookPaginationGetBooks'])->name('bookPaginationGetBooks');