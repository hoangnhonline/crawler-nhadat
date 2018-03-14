<?php
Route::get('/crawler', ['uses' => 'CrawlerController@crawler', 'as' => 'crawler']);
Route::get('muaban/', ['as' => 'muaban', 'uses' => 'CrawlerController@muaban']);
Route::get('mbnd/', ['as' => 'mbnd', 'uses' => 'CrawlerController@mbnd']);
Route::get('tuoitre/', ['as' => 'mbnd', 'uses' => 'CrawlerController@tuoitre']);
Route::get('nhadatnhanh/', ['as' => 'nhadatnhanh', 'uses' => 'CrawlerController@nhadatnhanh']);
Route::get('bds/', ['as' => 'bds', 'uses' => 'CrawlerController@bds']);
Route::get('chotot/', ['as' => 'chotot', 'uses' => 'CrawlerController@chotot']);

require (__DIR__ . '/Routes/backend.php');