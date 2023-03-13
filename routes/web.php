<?php

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


Route::get('/',function (){

    return redirect()->route('login');
});

Auth::routes();


Route::controller(\App\Http\Controllers\ChatController::class)->group(function (){

    Route::get('chat','index');
    Route::post('chat','store')->name('store');
    Route::get('rest','rest')->name('rest');

});
