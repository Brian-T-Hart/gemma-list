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
})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/glists', 'GlistsController@store');
Route::post('/glists/reorder', 'GlistsController@order');
Route::delete('/glists/{glist}/delete', 'GlistsController@destroy');
Route::patch('/glists/{glist}', 'GlistsController@update');
Route::patch('/glists/{glist}/archive', 'GlistsController@archive');

Route::post('/glists/{glist}/task', 'TasksController@store');
Route::post('/glists/{listId}/copyto/{glistId}', 'TasksController@copyto');
Route::post('/tasks/reorder', 'TasksController@order');
Route::patch('/tasks/completed/{task}', 'TasksController@completed');
Route::patch('/tasks/{task}', 'TasksController@update');
Route::delete('/tasks/delete/{glist}', 'TasksController@destroy');
Route::delete('/tasks', 'TasksController@destroyAll');
