<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiContoller;


Route::get('/',[AuthApiContoller::class,'index']);
Route::post('/register',[AuthApiContoller::class,'register']);
Route::post('/login',[AuthApiContoller::class,'login']);

