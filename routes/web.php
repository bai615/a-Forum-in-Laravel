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

//Route::get('/threads','ThreadsController@index');
//Route::post('/threads','ThreadsController@store');
//Route::get('/threads/{thread}','ThreadsController@show');

Route::get('/threads', 'threadsController@index')->name('threads.index');
Route::get('/threads/create', 'threadsController@create')->name('threads.create');
Route::get('/threads/{channel}/{thread}','ThreadsController@show');
Route::post('/threads', 'threadsController@store')->name('threads.store');
Route::get('threads/{channel}','ThreadsController@index');
Route::post('/threads/{channel}/{thread}/replies','RepliesController@store');
//Route::post('/threads/{thread}/replies','RepliesController@store');

Route::post('/replies/{reply}/favorites','FavoritesController@store');

Route::get('/profiles/{user}','ProfilesController@show')->name('profile');

// Route::resource('threads','ThreadsController');
/**
 * 上面资源路由等价于以下路由
Route::get('/threads', 'threadsController@index')->name('threads.index');
Route::get('/threads/{thread}', 'threadsController@show')->name('threads.show');
Route::get('/threads/create', 'threadsController@create')->name('threads.create');
Route::post('/threads', 'threadsController@store')->name('threads.store');
Route::get('/threads/{thread}/edit', 'threadsController@edit')->name('threads.edit');
Route::patch('/threads/{thread}', 'threadsController@update')->name('threads.update');
Route::delete('/threads/{thread}', 'threadsController@destroy')->name('threads.destroy');
 */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('blockchain','BlockchainController@index');
