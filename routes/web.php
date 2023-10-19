<?php

use App\Http\Controllers\data_controller;
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

Route::get('/',function(){
    return view('form');
});

Route::get('country_data',[data_controller::class,'country_data_fun']);
Route::get('country_id/{id}',[data_controller::class,'country_id_fun']);
Route::get('state_id/{id}',[data_controller::class,'state_id_fun']);
Route::post('form_data',[data_controller::class,'form_data_fun']);
Route::get('show_data',[data_controller::class,'show_data_fun']);
Route::get('delete/{id}',[data_controller::class,'delete_fun']);
Route::get('update/{id}',[data_controller::class,'update_fun']);