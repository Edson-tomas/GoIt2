<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', [ImageController::class , 'index'])->name('image.index');
Route::get('/images/{image}', [ImageController::class , 'show'])->name('image.show');
Route::get('/images', [ImageController::class , 'create'])->name('image.create');
Route::post('/images', [ImageController::class , 'store'])->name('image.store');
Route::get('/images/{image}/edit', [ImageController::class , 'edit'])->name('image.edit');
Route::put('/images/{image}', [ImageController::class , 'update'])->name('image.update');
Route::delete('/images/{image}', [ImageController::class , 'destroy'])->name('image.destroy');
