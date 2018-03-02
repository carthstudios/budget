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

Route::prefix('/config')->group(function () {
    Route::prefix('/categories')->group(function () {
        Route::get('/',             'config\CategoriesController@view');
        Route::get('/remove/{id}',  'config\CategoriesController@remove');
        Route::post('/edit/{id}',   'config\CategoriesController@edit');
        Route::post('/add',         'config\CategoriesController@add');
    });

    Route::prefix('/budget')->group(function () {
        Route::get('/',             'config\BudgetController@view');
        Route::post('/mupdate',     'config\BudgetController@monthly_update');
        Route::post('/pupdate',     'config\BudgetController@put_aside_update');
        Route::get('/premove/{id}', 'config\BudgetController@put_aside_remove');
        Route::post('/padd',        'config\BudgetController@put_aside_add');
    });
});

Route::prefix('/budget')->group(function () {
    Route::get('/{month?}/{year?}', 'BudgetOverviewController@view');
});

/*
@if($putAside->category->id == \App\BudgetPutAsidePlan::PUTSIDE_CATEGORY_ID)
    <span class='label lable-sm bg-blue bg-font-blue'> ACC </span>
@elseif($putAside->category->is_positive)
    <span class='label lable-sm bg-green-jungle bg-font-green-jungle'> IN </span>
@else
    <span class='label lable-sm bg-red bg-font-red'> OUT </span>
@endif
 */