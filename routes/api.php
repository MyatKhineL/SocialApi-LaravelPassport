<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiContoller;
use App\Http\Controllers\FeedApiController;
use App\Http\Controllers\LikeApiController;



Route::get('/',[AuthApiContoller::class,'index']);
Route::post('/register',[AuthApiContoller::class,'register']);
Route::post('/login',[AuthApiContoller::class,'login']);
//    Route::post('/feed/create',[FeedApiController::class,'create'])->middleware('auth');


Route::group(['middleware'=>'auth:api'],function () {
    Route::get('/feed',[FeedApiController::class,'feed']);
    Route::post('/feed/create',[FeedApiController::class,'create']);

    Route::post('comment/create',[FeedApiController::class,'createcomment']);
    Route::get('comment',[FeedApiController::class,'getComment']);
    Route::delete('comment/delete/',[FeedApiController::class,'deleteComment']);


    Route::post('like',[LikeApiController::class,'like']);
});






