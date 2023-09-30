<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function(){
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::group([
        'middleware' => 'auth:api'
    ], function(){
        Route::post('logout', 'App\Http\Controllers\AuthController@logout');
        Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
        Route::get('data', 'App\Http\Controllers\AuthController@data');
    }); 
});

Route::middleware('auth:api')->group(function () {
    Route::post('add_todo', 'App\Http\Controllers\TodoController@addTodo');
    Route::get('get_todo', 'App\Http\Controllers\TodoController@getTodoList');
    Route::get('todos', 'App\Http\Controllers\TodoController@index');
    Route::get('get_todo/{id}', 'App\Http\Controllers\TodoController@getTodoById');
    Route::delete('del_todo/{id}', 'App\Http\Controllers\TodoController@delTodoById');
    Route::put('update_todo/{id}', 'App\Http\Controllers\TodoController@updateTodo');
});

Route::post('register', 'App\Http\Controllers\UserController@addUser');

