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


/*
|---------------------------------------------------------------------------
| Root route
|---------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('index2');
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