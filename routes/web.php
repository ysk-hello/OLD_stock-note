<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\ArticleController::class, 'index']);

// 追加
Route::post('/article', [App\Http\Controllers\ArticleController::class, 'store']);

// 編集
Route::post('/article/edit/{article}', [App\Http\Controllers\ArticleController::class, 'edit']);
Route::get('/article/edit/{article}', [App\Http\Controllers\ArticleController::class, 'edit']); // バリデーションエラー時

// 更新
Route::post('/article/update', [App\Http\Controllers\ArticleController::class, 'update']);

// 削除
Route::delete('/article/{article}', [App\Http\Controllers\ArticleController::class, 'destroy']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\ArticleController::class, 'index'])->name('home');
