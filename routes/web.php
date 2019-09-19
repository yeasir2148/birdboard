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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/projects', 'ProjectsController@store');

Route::get('/projects', 'ProjectsController@index');
Route::get('/projects/{project}','ProjectsController@show');

Route::get('categories','CategoriesController@index');
Route::post('/categories','CategoriesController@store');
Route::delete('/categories/{category}','CategoriesController@destroy');

Route::get('/subcategories','SubcategoriesController@index');
Route::post('/subcategory','SubcategoriesController@store');
Route::delete('/subcategory/{subcategory}','SubcategoriesController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
