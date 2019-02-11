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
Route::middleware('api')->post('/register', 'RegisterController@register');
Route::middleware('api')->get('/register/active', 'RegisterController@active');
Route::middleware('api')->post('/login', 'LoginController@login');
Route::middleware('api')->post('/login/temp', 'LoginController@temp');
Route::middleware(['api', 'login'])->post('/article/add', 'ArticleController@add');
Route::middleware(['api', 'login'])->post('/comment/add', 'CommentController@add');
Route::middleware('api')->get('/article', 'ArticleController@check');
Route::middleware('api')->get('/article/list', 'ArticleController@list');
Route::middleware('api')->get('/comment/list', 'CommentController@list');
Route::middleware(['api', 'login'])->post('/upload/image', 'ImageController@image');
Route::middleware('api')->get('/article/search', 'ArticleController@search');
Route::middleware('api')->post('/user/base', 'UserController@base');
Route::middleware('api')->post('/user/nickname', 'UserController@nickname');
Route::middleware('api')->get('/link', 'LinkController@link');
Route::middleware(['api', 'login'])->post('/link/add', 'LinkController@add');
Route::middleware('api')->get('/guestbook', 'GuestbookController@list');
Route::middleware(['api', 'login'])->post('/guestbook/add', 'GuestbookController@add');

Route::middleware('api')->get('/test', function(){
	return view('test');
});
