<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "API" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register','AuthController@register');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'

], function ($router) {
    Route::Group(['prefix'=>'store'],function (){

        Route::post('','API\\StoreAPIController@index');
        Route::post('audit','API\\StoreAPIController@audit');
        Route::post('status','API\\StoreAPIController@status');
        Route::post('balance','API\\StoreAPIController@balance');
    });

    Route::Group(['prefix'=>'jobs'],function (){

        Route::get('','API\\JobsAPIController@index');
        Route::put('{id}','API\\JobsAPIController@update');
    });

    Route::Group(['prefix'=>'job_cat'],function (){
        Route::get('','API\\JobCateAPIController@index');
        Route::get('all','API\\JobCateAPIController@all');
        Route::post('','API\\JobCateAPIController@store');
        Route::get('tree','API\\JobCateAPIController@tree');
        Route::post('delete','API\\JobCateAPIController@delete');
        Route::put('{id}','API\\JobsAPIController@update');
    });

    Route::Group(['prefix'=>'app_user'],function (){

        Route::get('','API\\AppUserAPIController@index');
        Route::put('{id}','API\\JobsAPIController@update');
    });

    Route::Group(['prefix'=>'feed_back'],function (){

        Route::get('','API\\FeedBackAPIController@index');
        Route::post('audit','API\\FeedBackAPIController@audit');
    });
});






//Route::resource('jobs', 'JobsAPIController');
