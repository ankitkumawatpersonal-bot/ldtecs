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