<?php

Route::redirect('/', '/login');

Route::prefix('/login')->group(function () {
    Route::view('/',                'login');
    Route::get('/google',           'AccessController@google_login');
    Route::get('/google/callback',  'AccessController@google_callback');
});

Route::get('/dashboard', 'HomeController@index')->name('home');
