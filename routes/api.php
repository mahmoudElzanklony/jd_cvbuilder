<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\AuthControllerApi;
use App\Http\Controllers\JobsControllerResource;
use App\Http\Controllers\SkillsControllerResource;
use App\Http\Controllers\TitleDescriptionController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\classes\general\GeneralServiceController;

Route::get('/user',[AuthControllerApi::class,'user'])->middleware('CheckApiAuth');
Route::post('/login',[AuthControllerApi::class,'login_api']);

Route::group(['middleware'=>'changeLang'],function (){
    Route::post('/register',[AuthControllerApi::class,'register_post']);
    Route::post('/logout',[AuthControllerApi::class,'logout_api']);
    Route::post('/validate-user',[AuthControllerApi::class,'validate_user']);


    Route::group(['middleware'=>'guest'],function () {
        Route::resources([
            'jobs'=>JobsControllerResource::class,
            'skills'=>SkillsControllerResource::class,
            'countries'=>CountriesController::class, // countries Resource
            'cities'=>CitiesController::class // cities Resource
        ]);

    });

    Route::group(['prefix'=>'/titledesc'],function(){
        Route::post('/',[TitleDescriptionController::class,'all']);
        Route::post('save',[TitleDescriptionController::class,'save']);
    });
    Route::get('/jobs-ids',[JobsControllerResource::class,'ids']);

    Route::group(['prefix'=>'/jobs'],function(){
        Route::post('/names',[JobsControllerResource::class,'jobs_names']);
        Route::post('/dash',[JobsControllerResource::class,'jobs_dash']);
        Route::post('/parents',[JobsControllerResource::class,'parents']);
    });

    Route::group(['prefix'=>'/dashboard','middleware'=>'CheckApiAuth'],function(){
        Route::post('/users',[DashboardController::class,'users']);

        Route::group(['prefix'=>'/countries'],function(){
            Route::post('/',[DashboardController::class,'countries']);
            Route::post('/save',[DashboardController::class,'save_countries']);
        });
        Route::group(['prefix'=>'/skills'],function(){
            Route::post('/',[DashboardController::class,'get_skills']);
            Route::post('/save',[DashboardController::class,'save_skills']);
        });
        Route::group(['prefix'=>'/sk-groups'],function(){
            Route::post('/',[DashboardController::class,'get_sk_groups']);
            Route::post('/save',[DashboardController::class,'save_sk_groups']);
        });

        // sk-groups
    });

    Route::group(['prefix'=>'/users','middleware'=>'CheckApiAuth'],function(){
        Route::post('/save',[UsersController::class,'save']);
    });


    Route::post('/deleteitem',[GeneralServiceController::class,'delete_item']);


    Route::post('/upload-excel',[GeneralServiceController::class,'upload']);




});
