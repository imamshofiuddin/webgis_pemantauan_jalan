<?php

use App\Http\Controllers\RoadController;
use App\Http\Controllers\RoadMapController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [RoadMapController::class,'index'])->name('landing_page');

Auth::routes();

Route::group(['middleware'=>['auth','cekrole:admin,guest']], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/our_roads', [RoadMapController::class,'toRoadMap'])->name('road_map.index');

Route::get('/create', [RoadController::class,'create'])->name('roads.create');
Route::get('/index', [RoadController::class,'index'])->name('roads.index');
Route::post('/store', [RoadController::class,'store'])->name('roads.store');
Route::get('/show/{road}', [RoadController::class,'show'])->name('roads.show');
Route::get('/edit/{road}', [RoadController::class,'edit'])->name('roads.edit');
Route::patch('update/{road}',[RoadController::class,'update'])->name('roads.update');
Route::delete('delete/{road}',[RoadController::class,'destroy'])->name('roads.destroy');
Route::post('fix/{road}',[RoadController::class, 'roadFixedUpdate'])->name('roads.fixed');
Route::get('report',[RoadController::class, 'roadReport'])->name('roads.report');
Route::post('confirm/{road}',[RoadController::class, 'confirmReport'])->name('roads.confirm');
Route::get('statistic',[RoadController::class,'roadStatistic'])->name('roads.statistic');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/user/delete/{user}', [UserController::class, 'destroy'])->name('user.delete');
Route::get('/user/add', [UserController::class, 'create'])->name('user.add');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
