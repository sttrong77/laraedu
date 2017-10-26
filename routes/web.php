<?php

Route::get('/', function () {
    return view('welcome');
});

Route::prefix("admin")->group(function(){
    Auth::routes();

    Route::group([
        'namespace'=>'Admin\\',
        'as'=>'admin.',
        'middleware'=>'auth',
    ],function(){
        Route::name('dashboard')->get('/dashboard', function () {
            return "Dashboard";
        });
        Route::resource('users', 'UsersController');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
