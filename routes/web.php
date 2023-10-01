<?php
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
Route::group(['prefix'=>'/auth'],function(){
    Route::get('/{type}', function ($type) {
        return Socialite::driver($type)->redirect();
    });

    Route::get('/{type}/callback', function ($type) {
        $user = Socialite::driver($type)->user();
        return $user;
        // $user->token
    });
});

