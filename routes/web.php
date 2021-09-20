<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//emmploy route
Route::get('/home', [App\Http\Controllers\EmployController::class, 'index'])->name('home');
Route::post('/employ/store', [App\Http\Controllers\EmployController::class, 'store'])->name('employ-store');
// Route::get('/employ/{id}/edit', [App\Http\Controllers\EmployController::class, 'edit'])->name('edit-employ');
Route::get('employ/{id}', [App\Http\Controllers\EmployController::class, 'edit']);
Route::get('/employ/delete/{id}/', [App\Http\Controllers\EmployController::class, 'delete']);




