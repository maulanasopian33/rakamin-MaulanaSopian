<?php

use App\Http\Controllers\API\ArticlesController;
use Illuminate\Http\Request;
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
 Route::get('login', function(){
     return response([
         'status' => false,
         'message'  => 'Unautorized'
     ]);
 })->name('login');
 Route::get('a', 'App\Http\Controllers\API\ArticlesController@update');
 Route::get('/home', 'App\Http\Controllers\Controller@index')->middleware('auth:api');
