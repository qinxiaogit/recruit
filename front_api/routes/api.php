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
    Route::post('update', 'AuthController@update');
    Route::post('updateReal', 'AuthController@updateReal');
    Route::post('register','AuthController@register');


    Route::Group(['prefix'=>'wechat'],function () {
        Route::post('login', 'API\\WechatAPIController@login');
        Route::post('decode', 'API\\WechatAPIController@decode');
    });

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'

], function ($router) {
    Route::Group(['prefix'=>'jobs'],function (){
        Route::post('','API\\JobsAPIController@index');
        Route::get('show','API\\JobsAPIController@show');
        Route::get('record','API\\JobsAPIController@record');
        Route::get('recommend','API\\JobsAPIController@recommend');
    });

    Route::Group(['prefix'=>'job_cat'],function (){
        Route::get('tree','API\\JobCateAPIController@tree');
    });
    Route::Group(['prefix'=>'conf'],function (){
        Route::get('banner','API\\ConfAPIController@banner');
        Route::get('stat','API\\ConfAPIController@stat');
        Route::get('protocol','API\\ConfAPIController@protocol');
    });
});


Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'v1'

], function ($router) {
    Route::Group(['prefix'=>'public'],function () {
        Route::post('upload','PublicController@upload');
    });

     Route::Group(['prefix'=>'store'],function (){
        Route::post('','API\\StoreAPIController@index');
        Route::post('apply','API\\StoreAPIController@store');
        Route::post('status','API\\StoreAPIController@status');
        Route::post('balance','API\\StoreAPIController@balance');
        Route::get('show','API\\StoreAPIController@show');
        Route::get('me','API\\StoreAPIController@me');
    });

    Route::Group(['prefix'=>'jobs'],function (){
        Route::put('{id}','API\\JobsAPIController@update');
        Route::post('store','API\\JobsAPIController@store');
        Route::post('report','API\\JobsAPIController@report');
        Route::post('report_status','API\\JobsAPIController@reportStatus');
        Route::post('edit/{id}','API\\JobsAPIController@update');
    });

    Route::Group(['prefix'=>'job_cat'],function (){
        Route::get('','API\\JobCateAPIController@index');
        Route::get('all','API\\JobCateAPIController@all');
        Route::post('','API\\JobCateAPIController@store');
        Route::post('delete','API\\JobCateAPIController@delete');
        Route::put('{id}','API\\JobsAPIController@update');
        Route::get('select','API\\JobsAPIController@select');
    });

    Route::Group(['prefix'=>'app_user'],function (){

        Route::get('','API\\AppUserAPIController@index');
        Route::put('{id}','API\\JobsAPIController@update');
    });

    Route::Group(['prefix'=>'feed_back'],function (){
        Route::post('list','API\\FeedBackAPIController@index');
        Route::post('audit','API\\FeedBackAPIController@audit');
        Route::post('total','API\\FeedBackAPIController@total');
        Route::post('report','API\\FeedBackAPIController@report');
    });
});
