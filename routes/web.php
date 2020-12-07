<?php

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

Route::post('/a34d56','ApiController@adminOpsi');
Route::post('/deletetrs/{id}','ApiController@adminDelete');
Route::post('/adminloginpage','ApiController@pagelogin');
Route::get('/booking/','ApiController@viewbooking');
