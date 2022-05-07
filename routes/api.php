<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiContoller;
use App\Http\Controllers\FeedApiController;



Route::get('/',[AuthApiContoller::class,'index']);
Route::post('/register',[AuthApiContoller::class,'register']);
Route::post('/login',[AuthApiContoller::class,'login']);
//    Route::post('/feed/create',[FeedApiController::class,'create'])->middleware('auth');


Route::group(['middleware'=>'auth:api'],function () {
    Route::post('/feed/create',[FeedApiController::class,'create']);

});






