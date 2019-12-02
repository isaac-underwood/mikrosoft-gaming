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

// Resource Routes:
Route::resource('/groups','GroupsController')->middleware('auth');
Route::resource('/games','GamesController')->middleware('auth');
Route::resource('/bans', 'UserBanController')->middleware('auth');
Route::resource('/highscores', 'HighscoresController')->middleware('auth');
Route::resource('/players', 'PlayersController')->middleware('auth');
Route::resource('/profile', 'ProfileController')->middleware('auth'); //Adding middleware protects route(s) from unverified account

// Post Routes:
Route::post('bans/request', 'UserBanController@create')->name('bans.gotorequest');
Route::post('/games/show', 'GamesController@storeHighScores');
Route::post('/highscores/create', 'GamesController@createHighScore')->name('games.gotocreate')->middleware('verified');
Route::post('/groups/{id}','GroupsController@removeUser')->name('groups.removeUser');
Route::post('/highscores/create', 'GamesController@createHighScore')->name('games.gotocreate')->middleware('auth');
Route::post('/groups/{id}/users/add', 'GroupsController@updateUsers')->name('groups.updateusers')->middleware('auth');
Route::post('/groups/{id}/users/remove', 'GroupsController@removeUsers')->name('groups.removeusers')->middleware('auth');

// Get Routes:
Route::get('/','PagesController@index')->name('pages.index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/groups/{id}/edit', 'GroupsController@edit')->name('groups.edit')->middleware('auth', 'groupowner');
Route::get('/groups/{id}/users/add', 'GroupsController@addUsers')->name('groups.showaddusers')->middleware('auth', 'groupowner');
Route::get('/groups/{id}/users/remove', 'GroupsController@showRemoveUsers')->name('groups.showremoveusers')->middleware('auth', 'groupowner');


// Auth Routes:
Auth::routes();
Auth::routes(['verify' => true]);