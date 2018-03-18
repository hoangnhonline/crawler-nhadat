<?php
Route::get('muaban/', ['as' => 'muaban', 'uses' => 'CrawlerController@muaban']);
Route::get('muabannhadat/', ['as' => 'muabannhadat', 'uses' => 'CrawlerController@muabannhadat']);
Route::get('batdongsan/', ['as' => 'batdongsan', 'uses' => 'CrawlerController@batdongsan']);
Route::get('nhadatnhanh/', ['as' => 'nhadatnhanh', 'uses' => 'CrawlerController@nhadatnhanh']);
require (__DIR__ . '/Routes/backend.php');