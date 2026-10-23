<?php

use App\Http\Controllers\LdController;

Route::get('/', [LdController::class,'index']);

Route::get('/about', function () {
    return view('about');
});

Route::get('/product', function () {
    return view('/#our-products');
});

Route::get('/technology', function () {
    return view('technology');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/career', function () {
    return view('career');
});

Route::get('/elite', function () {
    return view('elite');
});
Route::get('/lite', function () {
    return view('lite');
});
Route::get('/nano', function () {
    return view('nano');
});

Route::get('/technology-solution', function () {
    return view('technology-solution');
});

Route::get('/software-development', function () {
    return view('software-development');
});

Route::get('/machine-learning', function () {
    return view('machine-learning');
});

Route::get('/automation-software', function () {
    return view('automation-software');
});
Route::get('/embedded-software', function () {
    return view('embedded-software');
});
Route::get('/3d-printing', function () {
    return view('3d-printing');
});

Route::get('/cad-design', function () {
    return view('cad-design');
});
Route::get('/r&d-services', function () {
    return view('r&d-services');
});