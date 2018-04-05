<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth']], function () {

    /*
    |---------------------------------------------------------------------------
    | Root route
    |---------------------------------------------------------------------------
    */
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    //only authorized users can access these routes
    Route::prefix('users')->group(function () {
        Route::get('create', 'UserController@create')->name('users.create');
        Route::post('store', 'UserController@store')->name('users.store');
        Route::get('', 'UserController@index')->name('users.list');
        Route::get('{id}/show', 'UserController@show')->name('users.show');
        Route::get('{id}/edit', 'UserController@edit')->name('users.edit');
        Route::get('{id}/delete', 'UserController@destroy')->name('users.delete');
        Route::post('{id}/password', 'UserController@passwordUpdate')->name('users.passwordUpdate');
        Route::post('{id}', 'UserController@update')->name('users.update');

    });

    Route::prefix('boards')->group(function () {
        Route::get('create', 'BoardController@create')->name('boards.create');
        Route::post('store', 'BoardController@store')->name('boards.store');
        Route::post('column', 'BoardController@addColumn')->name('boards.column');
        Route::get('', 'BoardController@index')->name('boards.list');
        Route::get('{id}/show', 'BoardController@show')->name('boards.show');
        Route::get('{id}/edit', 'BoardController@edit')->name('boards.edit');
        Route::get('{id}/delete', 'BoardController@destroy')->name('boards.delete');
        Route::post('{id}', 'BoardController@update')->name('boards.update');

    });

    Route::prefix('projects')->group(function () {
        Route::get('create', 'ProjectController@create')->name('projects.create');
        Route::post('store', 'ProjectController@store')->name('projects.store');
        Route::get('', 'ProjectController@index')->name('projects.list');
        Route::get('{id}/show', 'ProjectController@show')->name('projects.show');
        Route::post('{id}/show', 'ProjectController@activate')->name('projects.activate');
        Route::get('{id}/edit', 'ProjectController@edit')->name('projects.edit');
        Route::get('{project}/delete', 'ProjectController@destroy')->name('projects.delete');
        Route::post('{project}', 'ProjectController@update')->name('projects.update');

    });

    Route::prefix('groups')->group(function () {
        Route::get('create', 'GroupController@create')->name('groups.create');
        Route::post('store', 'GroupController@store')->name('groups.store');
        Route::get('', 'GroupController@index')->name('groups.list');
        Route::get('{id}/show', 'GroupController@show')->name('groups.show');
        Route::get('{id}/edit', 'GroupController@edit')->name('groups.edit');
        Route::get('{id}/delete', 'GroupController@destroy')->name('groups.delete');
        Route::post('{id}', 'GroupController@update')->name('groups.update');

    });

    Route::prefix('cards')->group(function () {
        Route::post('store', 'CardController@store')->name('cards.store');
        Route::get('{id}/edit/{board?}/{column?}', 'CardController@edit')->name('cards.edit');
        Route::get('{id}/delete', 'CardController@destroy')->name('cards.delete');
        Route::post('{id}', 'CardController@update')->name('cards.update');

    });
});

Route::group(['middleware' => ['guest']], function () {
    //only guests can access these routes
});

/*
|---------------------------------------------------------------------------
| Tables routes
|---------------------------------------------------------------------------
*/
Route::get('/pages/tables/simple', function () {
    return view('/tables/simple');
});

Route::get('/pages/tables/data', function () {
    return view('/tables/data');
});


/*
|---------------------------------------------------------------------------
| Calendar route
|---------------------------------------------------------------------------
*/
Route::get('/pages/calendar/index', function () {
    return view('/calendar/index');
});


/*
|---------------------------------------------------------------------------
| Charts routes
|---------------------------------------------------------------------------
*/
Route::get('/pages/charts/chartjs', function () {
    return view('/charts/chartjs');
});

Route::get('/pages/charts/flot', function () {
    return view('/charts/flot');
});

Route::get('/pages/charts/inline', function () {
    return view('/charts/inline');
});

Route::get('/pages/charts/morris', function () {
    return view('/charts/morris');
});


/*
|---------------------------------------------------------------------------
| Forms routes
|---------------------------------------------------------------------------
*/
Route::get('/pages/forms/advanced', function () {
    return view('/forms/advanced');
});

Route::get('/pages/forms/editors', function () {
    return view('/forms/editors');
});

Route::get('/pages/forms/general', function () {
    return view('/forms/general');
});


/*
|---------------------------------------------------------------------------
| Layout routes
|---------------------------------------------------------------------------
*/
Route::get('/pages/layout/boxed', function () {
    return view('/layout/boxed');
});

Route::get('/pages/layout/collapsed-sidebar', function () {
    return view('/layout/collapsed-sidebar');
});

Route::get('/pages/layout/fixed', function () {
    return view('/layout/fixed');
});

Route::get('/pages/layout/top-nav', function () {
    return view('/layout/top-nav');
});


/*
|---------------------------------------------------------------------------
| Widgets route
|---------------------------------------------------------------------------
*/
Route::get('/pages/widgets/index', function () {
    return view('/widgets/index');
});


/*
|---------------------------------------------------------------------------
| UI routes
|---------------------------------------------------------------------------
*/
Route::get('/pages/UI/buttons', function () {
    return view('/UI/buttons');
});

Route::get('/pages/UI/general', function () {
    return view('/UI/general');
});

Route::get('/pages/UI/icons', function () {
    return view('/UI/icons');
});

Route::get('/pages/UI/modals', function () {
    return view('/UI/modals');
});

Route::get('/pages/UI/sliders', function () {
    return view('/UI/sliders');
});

Route::get('/pages/UI/timeline', function () {
    return view('/UI/timeline');
});


/*
|---------------------------------------------------------------------------
| Mailbox routes
|---------------------------------------------------------------------------
*/
Route::get('/pages/mailbox/compose', function () {
    return view('/mailbox/compose');
});

Route::get('/pages/mailbox/mailbox', function () {
    return view('/mailbox/mailbox');
});

Route::get('/pages/mailbox/read-mail', function () {
    return view('/mailbox/read-mail');
});

Route::get('/pages/mailbox/compose', function () {
    return view('/mailbox/compose');
});


/*
|---------------------------------------------------------------------------
| Login route
|---------------------------------------------------------------------------
*/
Route::get('login',
    function () {
        return view('/login/login');
    }
)->name('login');

Route::post('login','Auth\LoginController@login')->name('login.test');
