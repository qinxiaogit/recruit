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
    Route::group([
        'prefix' => 'backend'
    ], function () {
        Route::post('login', 'Backend\\AuthController@login');
        Route::post('logout', 'Backend\\AuthController@logout');
        Route::post('me', 'Backend\\AuthController@me');
    });
    Route::group([
        'prefix' => 'front'
    ], function () {
        Route::post('login', 'API\\AuthController@login');
        Route::post('logout', 'API\\AuthController@logout');
        Route::post('me', 'API\\AuthController@me');
    });
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {
    Route::group([
        'prefix' => 'front'
    ], function () {
        Route::get('home/init', 'API\\HomeController@init');
        Route::get('course/category', 'API\\CourseController@category');
        Route::get('course/init', 'API\\CourseController@init');
        Route::get('course/list', 'API\\CourseController@index');

        Route::get('script/list', 'API\\ScriptController@index');
        Route::get('script/collect', 'API\\ScriptController@collect');
        Route::get('script/collectList', 'API\\ScriptController@collectList');
        Route::get('script/show', 'API\\ScriptController@show');

        Route::get('material/market', 'API\\MaterialController@market');
        Route::get('material/circle', 'API\\MaterialController@circle');
        Route::get('material/collect', 'API\\MaterialController@collect');
        Route::get('material/collectList', 'API\\MaterialController@collectList');

        Route::get('resource/list', 'API\\ResourceController@index');
    });
    Route::group([
        'prefix' => 'backend'
    ], function () {

    });
});



//
//Route::group([
//    'middleware' => 'api',
//    'prefix' => 'v1'
//
//], function ($router) {
//    Route::Group(['prefix'=>'public'],function () {
//        Route::post('upload','PublicController@upload');
//    });
//
//     Route::Group(['prefix'=>'store'],function (){
//        Route::post('','API\\StoreAPIController@index');
//        Route::post('audit','API\\StoreAPIController@audit');
//        Route::post('status','API\\StoreAPIController@status');
//        Route::post('balance','API\\StoreAPIController@balance');
//        Route::get('show','API\\StoreAPIController@show');
//    });
//});


//Route::resource('jobs', 'JobsAPIController');
