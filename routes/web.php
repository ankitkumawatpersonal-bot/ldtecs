
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LdController;

Route::get('/', [LdController::class, 'index'])->name('home');

Route::view('/about', 'about');
Route::view('/technology', 'technology');
Route::view('/services', 'services');
Route::view('/career', 'career');

Route::view('/elite', 'elite');
Route::view('/lite', 'lite');
Route::view('/nano', 'nano');

Route::view('/technology-solution', 'technology-solution');

Route::view('/software-development', 'software-development');
Route::view('/machine-learning', 'machine-learning');
Route::view('/automation-software', 'automation-software');
Route::view('/embedded-software', 'embedded-software');

Route::view('/3d-printing', '3d-printing');
Route::view('/cad-design', 'cad-design');
Route::view('/r&d-services', 'r&d-services');

// Product link: Home page ke Our Products section par le jao
Route::get('/product', function () {
    return redirect('/#our-products');
});
