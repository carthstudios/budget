<?php

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('/login')->group(function () {
    Route::view('/',                'access.login')->name('login');
    Route::get('/google',           'AccessController@google_login');
    Route::get('/google/callback',  'AccessController@google_callback');
    Route::get('/close',            'AccessController@logout');
});

Route::prefix('/records')->group(function () {
    Route::post('/create',          'RecordsController@create');
});

Route::prefix('/family')->group(function () {
    Route::get('/',                'FamilyController@view_list');
    Route::post('/add',            'FamilyController@add');
    Route::post('/name',           'FamilyController@save_name');
});
