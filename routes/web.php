<?php

Route::redirect('/', '/dashboard');

Route::prefix('/login')->group(function () {
    Route::view('/',                'access.login')->name('login');
    Route::get('/google',           'AccessController@google_login');
    Route::get('/google/callback',  'AccessController@google_callback');
    Route::get('/close',            'AccessController@logout');
});

Route::get('/dashboard', 'HomeController@index')->name('home');
