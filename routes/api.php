<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|-------------------------------------------------------------------------------
| Updates a User's Profile
|-------------------------------------------------------------------------------
| URL:            /api/v1/user
| Controller:     API\UsersController@putUpdateUser
| Method:         PUT
| Description:    Updates the authenticated user's profile
*/
Route::put('/user', 'UsersController@putUpdateUser');