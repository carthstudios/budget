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
        Route::get('/',             'admin\FamiliesController@view');
        Route::post('/add',         'admin\FamiliesController@family_add');
        Route::prefix('/member')->group(function () {
            Route::post('/add',             'admin\FamiliesController@member_add');
            Route::post('/add_new',         'admin\FamiliesController@member_add_new');
            Route::post('/rename',          'admin\FamiliesController@member_rename');
            Route::get('/remove/{user_id}', 'admin\FamiliesController@member_remove');
        });
    });
});

Route::prefix('/configurations')->group(function () {
    Route::get('/',                     'ConfigurationsController@view');
    Route::post('/category_edit/{id}',  'ConfigurationsController@category_edit');
    Route::post('/category_add',        'ConfigurationsController@category_add');
    Route::get('/category_remove/{id}', 'ConfigurationsController@category_remove');
    Route::post('/budget_update/{id}',  'ConfigurationsController@budget_update');
    Route::post('/putaside_add',        'ConfigurationsController@putaside_add');
    Route::post('/putaside_edit/{id}',  'ConfigurationsController@putaside_edit');
    Route::get('/putaside_remove/{id}', 'ConfigurationsController@putaside_remove');
});

Route::prefix('/budget')->group(function () {
    Route::get('/{month?}/{year?}', 'BudgetController@view');
});