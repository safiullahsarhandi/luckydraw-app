<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WheelController;
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

Route::group([], function() {
    Route::resource('users', UserController::class);
    Route::get('wheel-users', [WheelController::class,'wheel_users']);
    Route::post('announce-winner', [WheelController::class,'announce_winner']);

});
Route::get('{path?}', function () {
    return view('welcome');
})->where('path','.*');

Auth::routes();