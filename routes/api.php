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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'student'], function () {
        Route::get('/','studentController@getStudent');
        Route::post('add-student','studentController@storeStudent');
        Route::get('get-student/{student_id}','studentController@showStudent');
        Route::post('update-student/{student_id}','studentController@updateStudent');
        Route::get('delete-student/{student_id}','studentController@deleteStudent');
    });
});
