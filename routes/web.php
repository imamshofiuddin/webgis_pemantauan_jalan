<?php

use App\Http\Controllers\RoadController;
use App\Http\Controllers\RoadMapController;
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

Route::get('/', [RoadMapController::class,'index']);

Auth::routes();

Route::group(['middleware'=>['auth','cekrole:admin,guest']], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/our_roads', [RoadMapController::class,'index'])->name('road_map.index');

Route::get('/create', [RoadController::class,'create'])->name('roads.create');
Route::get('/index', [RoadController::class,'index'])->name('roads.index');
Route::post('/store', [RoadController::class,'store'])->name('roads.store');
Route::get('/show/{road}', [RoadController::class,'show'])->name('roads.show');
Route::get('/edit', [RoadController::class,'edit'])->name('roads.edit');
