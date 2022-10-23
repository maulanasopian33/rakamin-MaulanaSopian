<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function () {
    Route::get('/', 'App\Http\Controllers\API\MainController@index')->middleware('auth:api');
    Route::post('/login', 'App\Http\Controllers\API\MainController@login');
    Route::get('a', function(){
        dd(Auth::user());
    });
});
