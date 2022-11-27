<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\WaitingController;
use App\Http\Controllers\Controller;
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

Route::get('/', [Controller::class, 'index'])->name('top');

Auth::routes();

// Common

Route::get('/home', [Controller::class, 'index'])->name('home');
Route::post('/driver/search/', [Controller::class,'dsearch'])->name('driver.search');
Route::post('/reserve/search/', [Controller::class,'rsearch'])->name('reserve.search');
Route::post('/reserve/add_ship/', [Controller::class,'add_ship'])->name('reserve.add_ship');


// User

Route::get('/user/index', [UserController::class,'index'])->name('user.index');
Route::get('/user/{user}/show', [UserController::class,'show'])->name('user.show') ->where('user', '[0-9]+');
Route::get('/user/{user}/edit', [UserController::class,'edit'])->name('user.edit') ->where('user', '[0-9]+');
Route::patch('/user/{user}/update', [UserController::class,'update'])->name('user.update') ->where('user', '[0-9]+');
Route::delete('/user/{user}/destroy', [UserController::class,'destroy'])->name('user.destroy') ->where('user', '[0-9]+');
Route::get('/user/{user}/reserve', [UserController::class,'reserve'])->name('user.reserve') ->where('user', '[0-9]+');

// Reserve

Route::post('/reserve/store', [ReserveController::class,'store'])->name('reserve.store');
Route::post('/reserve/waitStore', [ReserveController::class,'waitStore'])->name('reserve.waitStore');
Route::post('/reserve/determine', [ReserveController::class,'determine'])->name('reserve.determine');
Route::get('/reserve/index', [ReserveController::class,'index'])->name('reserve.index');
Route::get('/reserve/{reserveList}/edit', [ReserveController::class,'edit'])->name('reserve.edit') ->where('reserve', '[0-9]+');
Route::get('/reserve/{reserveList}/shipEdit', [ReserveController::class,'shipEdit'])->name('reserve.shipEdit') ->where('reserve', '[0-9]+');
Route::post('/reserve/patternEdit', [ReserveController::class,'patternEdit'])->name('reserve.patternEdit') ->where('reserve', '[0-9]+');
Route::post('/reserve/driverEdit', [ReserveController::class,'driverEdit'])->name('reserve.driverEdit') ->where('reserve', '[0-9]+');
Route::delete('/reserve/shipDel', [ReserveController::class,'shipDel'])->name('reserve.shipDel') ->where('reserve', '[0-9]+');
Route::delete('/reserve/waitShipDel', [ReserveController::class,'waitShipDel'])->name('reserve.waitShipDel') ->where('reserve', '[0-9]+');
Route::patch('/reserve/{reserveList}/update', [ReserveController::class,'update'])->name('reserve.update') ->where('reserve', '[0-9]+');
Route::delete('/reserve/{reserveList}/destroy', [ReserveController::class,'destroy'])->name('reserve.destroy') ->where('reserve', '[0-9]+');

//Waiting
Route::get('/waiting/{waiting}/edit', [WaitingController::class,'edit'])->name('waiting.edit') ->where('waiting', '[0-9]+');
Route::get('/waiting/{waiting}/shipEdit', [WaitingController::class,'shipEdit'])->name('waiting.shipEdit') ->where('waiting', '[0-9]+');
Route::patch('/waiting/{waiting}/update', [WaitingController::class,'update'])->name('waiting.update') ->where('waiting', '[0-9]+');
Route::delete('/waiting/{waiting}/destroy', [WaitingController::class,'destroy'])->name('waiting.destroy') ->where('waiting', '[0-9]+');
