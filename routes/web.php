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

Route::get('/family',               'FamilyController@view');

Route::prefix('/admin')->group(function () {
    Route::prefix('/families')->group(function () {
        Route::get('/',             'Admin\FamiliesController@view');
        Route::post('/add',         'Admin\FamiliesController@family_add');
        Route::prefix('/member')->group(function () {
            Route::post('/add',             'Admin\FamiliesController@member_add');
            Route::post('/add_new',         'Admin\FamiliesController@member_add_new');
            Route::post('/rename',          'Admin\FamiliesController@member_rename');
            Route::get('/remove/{user_id}', 'Admin\FamiliesController@member_remove');
        });
    });
});
