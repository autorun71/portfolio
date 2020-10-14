<?php

use Illuminate\Http\Request;
use Laravel\Passport\Passport;
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

//Route::middleware('auth:api')->get('/is_valid_token', function (Request $request) {
//    return $request->user();
//});
/****** START | Работа с авторизацией ******/
//Route::middleware('auth:api')->get('/is_valid_token', 'Api\TokenController@isValid');

Route::options('*', 'Api\AuthController@options');

Route::post('/register', 'Api\AuthController@register');
//Route::options('/register', 'Api\AuthController@options');

Route::post('/login', 'Api\AuthController@login');
//Route::options('/login', 'Api\AuthController@options');



/****** END | Работа с авторизацией ******/

Route::group(['middleware' => 'auth:api'], function ()  {
    Route::get('/is_valid_token', 'Api\TokenController@isValid');
    Route::get('/token_clear', 'Api\AuthController@tokenClear');
    Route::get('/playlist', 'Api\AudioController@getAll');

    /****** START | Messages ******/
    Route::get('/messages/dialog/{id}/{send_id}', 'Api\MessagesController@getDialog');
    Route::get('/messages/dialogs/{id}', 'Api\MessagesController@getDialogs');
    Route::get('/messages/ms/{id}', 'Api\MessagesController@checkMess');

    Route::post('/messages/add', 'Api\MessagesController@addMess');
    Route::put('/messages/delete', 'Api\MessagesController@dellMess');



    /****** END | Messages ******/

});
/****** START | Player ******/

Route::get('/audio.mp3', 'Api\AudioController@getAudio');

/****** END | Player ******/

/****** START | Users ******/
Route::get('/user/{id}', 'Api\UserController@getUser');

/****** END | Users ******/

//Route::options('/messages/add', 'Api\AuthController@options');
//Route::options('/messages/delete', 'Api\AuthController@options');
