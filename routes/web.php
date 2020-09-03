<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'ProductController@index')->middleware(['auth.shopify'])->name('home');

Route::get('/preferences', function () {
    return view('welcome');
})->middleware(['auth.shopify'])->name('preferences');
Route::get('/test', 'ProductController@index')->middleware(['auth.shopify'])->name('test');
Route::get('/generator', 'ProductController@generator')->middleware(['auth.shopify'])->name('generator');
Route::get('/yml', 'FeedController@index')->name('yml');
