<?php

use App\Http\Controllers\TodoController;
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



Route::get('/',[TodoController::class, 'index'])->name('index');
Route::get('todos/{todo}/edit',[TodoController::class, 'edit'])->name('edit');
Route::post('todos/store',[TodoController::class, 'store'])->name('store');
Route::delete('todos/destroy/{todo}',[TodoController::class, 'delete'])->name('delete');
