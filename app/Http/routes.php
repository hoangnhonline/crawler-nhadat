<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/crawler', ['uses' => 'CrawlerController@ward', 'as' => 'crawler']);
Route::get('muaban/', ['as' => 'muaban', 'uses' => 'CrawlerController@muaban']);
Route::get('chotot/', ['as' => 'chotot', 'uses' => 'CrawlerController@chotot']);
Route::get('muaban2/', ['as' => 'muaban2', 'uses' => 'CrawlerController@muaban2']);
Route::get('muabanDetail/', ['as' => 'muabanDetail', 'uses' => 'CrawlerController@muabanDetail']);
Route::get('/project', ['uses' => 'CrawlerController@project', 'as' => 'project']);
Route::get('/ward', ['uses' => 'CrawlerController@ward', 'as' => 'ward']);
Route::get('/street', ['uses' => 'CrawlerController@street', 'as' => 'street']);
Route::get('/product', ['uses' => 'CrawlerController@product', 'as' => 'product']);
Route::get('/articles', ['uses' => 'CrawlerController@articles', 'as' => 'articles']);
Route::post('/get-child', ['uses' => 'Frontend\HomeController@getChild', 'as' => 'get-child']);
require (__DIR__ . '/Routes/backend.php');
require (__DIR__ . '/Routes/frontend.php');
