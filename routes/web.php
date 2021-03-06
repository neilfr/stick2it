<?php

use App\Http\Controllers\FoodController;
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

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia\Inertia::render('Dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/', 'LogentryController@index')->name('logentries.index');

    Route::get('/foods', 'FoodController@index')->name('foods.index');
    Route::get('/foods/new', 'FoodController@create')->name('foods.create');
    Route::post('/foods', 'FoodController@store')->name('foods.store');
    Route::get('/foods/{food}', 'FoodController@show')->name('foods.show');
    Route::patch('/foods/{food}', 'FoodController@update')->name('foods.update');
    Route::delete('/foods/{food}', 'FoodController@destroy')->name('foods.destroy');
    Route::post('/foods/{food}/toggle-favourite', 'FoodController@toggleFavourite')->name('foods.toggle-favourite');

    Route::get('/foods/{food}/ingredients', 'FoodIngredientController@index')->name('foods.ingredients.index');
    Route::post('/foods/{food}/ingredients', 'FoodIngredientController@store')->name('foods.ingredients.store');
    Route::patch('/foods/{food}/ingredients/{ingredient}', 'FoodIngredientController@update')->name('foods.ingredients.update');
    Route::delete('/foods/{food}/ingredients/{ingredient}', 'FoodIngredientController@destroy')->name('foods.ingredients.destroy');

    Route::get('/logentries', 'LogentryController@index')->name('logentries.index');
    Route::get('/logentries/new', 'LogentryController@create')->name('logentries.create');
    Route::post('/logentries', 'LogentryController@store')->name('logentries.store');
    Route::delete('/logentries/{logentry}', 'LogentryController@destroy')->name('logentries.destroy');
    Route::patch('/logentries/{logentry}', 'LogentryController@update')->name('logentries.update');
    Route::get('/logentries/{logentry}', 'LogentryController@edit')->name('logentries.edit');

});


