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

        Route::post('','Api\\StoreApiController@index');
        Route::post('audit','Api\\StoreApiController@audit');
        Route::post('status','Api\\StoreApiController@status');
        Route::post('balance','Api\\StoreApiController@balance');
    });

    Route::Group(['prefix'=>'jobs'],function (){

        Route::get('','Api\\JobsApiController@index');
        Route::put('{id}','Api\\JobsApiController@update');
    });

    Route::Group(['prefix'=>'job_cat'],function (){
        Route::get('','Api\\JobCateAPIController@index');
        Route::get('all','Api\\JobCateAPIController@all');
        Route::post('','Api\\JobCateApiController@store');
        Route::get('tree','Api\\JobCateApiController@tree');
        Route::post('delete','Api\\JobCateApiController@delete');
        Route::put('{id}','Api\\JobsApiController@update');
    });

    Route::Group(['prefix'=>'app_user'],function (){

        Route::get('','Api\\AppUserApiController@index');
        Route::put('{id}','Api\\JobsAPIController@update');
    });

    Route::Group(['prefix'=>'feed_back'],function (){

        Route::get('','Api\\FeedBackAPIController@index');
        Route::post('audit','Api\\FeedBackAPIController@audit');
    });
});






//Route::resource('jobs', 'JobsAPIController');
