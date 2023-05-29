<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\AuthControllerApi;
use App\Http\Controllers\JobsControllerResource;


Route::group(['middleware'=>'changeLang'],function (){
    Route::post('/register',[AuthControllerApi::class,'register_post']);
    Route::post('/login',[AuthControllerApi::class,'login_api']);
    Route::post('/logout',[AuthControllerApi::class,'logout_api']);

    Route::group(['middleware'=>'CheckApiAuth'],function () {
        Route::resources([
            'jobs'=>JobsControllerResource::class
        ]);
    });



});
