<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\AuthControllerApi;
use App\Http\Controllers\JobsControllerResource;
use App\Http\Controllers\SkillsControllerResource;
use App\Http\Controllers\TitleDescriptionController;


Route::group(['middleware'=>'changeLang'],function (){
    Route::post('/register',[AuthControllerApi::class,'register_post']);
    Route::post('/login',[AuthControllerApi::class,'login_api']);
    Route::post('/logout',[AuthControllerApi::class,'logout_api']);

    Route::group(['middleware'=>'CheckApiAuth'],function () {
        Route::resources([
            'jobs'=>JobsControllerResource::class,
            'skills'=>SkillsControllerResource::class
        ]);
        Route::group(['prefix'=>'/titledesc'],function(){
            Route::post('/',[TitleDescriptionController::class,'all']);
            Route::post('save',[TitleDescriptionController::class,'save']);
        });
    });



});
