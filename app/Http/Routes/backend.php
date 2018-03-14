<?php
// Authentication routes...
Route::get('backend/login', ['as' => 'backend.login-form', 'uses' => 'Backend\UserController@loginForm']);
Route::post('backend/login', ['as' => 'backend.check-login', 'uses' => 'Backend\UserController@checkLogin']);
Route::get('backend/logout', ['as' => 'backend.logout', 'uses' => 'Backend\UserController@logout']);
Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'middleware' => 'isAdmin'], function()
{   
    Route::get('dashboard', ['as' => 'data.index', 'uses' => "SettingsController@dashboard"]);
    Route::group(['prefix' => 'compare'], function () {
        Route::get('/', ['as' => 'compare.index', 'uses' => 'CompareController@index']);
    });    
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);
        Route::post('/update', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
        Route::get('/noti', ['as' => 'settings.noti', 'uses' => 'SettingsController@noti']);        
        Route::post('/storeNoti', ['as' => 'settings.store-noti', 'uses' => 'SettingsController@storeNoti']);
    });
    Route::group(['prefix' => 'data'], function () {
        Route::get('/', ['as' => 'data.index', 'uses' => 'DataController@index']);
        Route::get('/create', ['as' => 'data.create', 'uses' => 'DataController@create']);        
        Route::post('/store', ['as' => 'data.store', 'uses' => 'DataController@store']);
        Route::post('/storeUpload', ['as' => 'data.storeUpload', 'uses' => 'DataController@storeUpload']);
        Route::get('{id}/edit',   ['as' => 'data.edit', 'uses' => 'DataController@edit']);       
        Route::get('{id}/upload',   ['as' => 'data.upload', 'uses' => 'DataController@upload']);  
        Route::get('{id}/destroy', ['as' => 'data.destroy', 'uses' => 'DataController@destroy']);
        Route::get('{id}/detail',   ['as' => 'data.detail', 'uses' => 'DataController@detail']);
        Route::post('/update', ['as' => 'data.update', 'uses' => 'DataController@update']);
    });
     Route::group(['prefix' => 'hen'], function () {
        Route::get('/', ['as' => 'hen.index', 'uses' => 'HenController@index']);
        Route::get('/ajax-list', ['as' => 'hen.ajax-list', 'uses' => 'HenController@ajaxList']);
        Route::get('/create', ['as' => 'hen.create', 'uses' => 'HenController@create']);
        Route::post('/store', ['as' => 'hen.store', 'uses' => 'HenController@store']);
        Route::get('{id}/edit',   ['as' => 'hen.edit', 'uses' => 'HenController@edit']);       
        Route::get('{id}/destroy', ['as' => 'hen.destroy', 'uses' => 'HenController@destroy']);
        Route::post('/update', ['as' => 'hen.update', 'uses' => 'HenController@update']);
    });
    
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', ['as' => 'product.index', 'uses' => 'ProductController@index']); 
        Route::get('/kygui', ['as' => 'product.kygui', 'uses' => 'ProductController@kygui']);        
        Route::get('/ajax-get-detail-product', ['as' => 'ajax-get-detail-product', 'uses' => 'ProductController@ajaxDetail']);        
        Route::get('/create/', ['as' => 'product.create', 'uses' => 'ProductController@create']);        
        Route::post('/store', ['as' => 'product.store', 'uses' => 'ProductController@store']);        
        Route::get('{id}/edit',   ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
        Route::post('/update', ['as' => 'product.update', 'uses' => 'ProductController@update']);       
        Route::post('/save-order-hot', ['as' => 'product.save-order-hot', 'uses' => 'ProductController@saveOrderHot']);       
        Route::get('{id}/destroy', ['as' => 'product.destroy', 'uses' => 'ProductController@destroy']);
        Route::get('/ajax-get-tien-ich', ['as' => 'product.ajax-get-tien-ich', 'uses' => 'ProductController@ajaxGetTienIch']);
        Route::get('{id}/customer-join-sale', ['as' => 'product.customer-join-sale', 'uses' => 'ProductController@customerJoinSale']);
        Route::post('ajax-update-customer-join-sale', ['as' => 'product.ajax-update-customer-join-sale', 'uses' => 'ProductController@ajaxUpdateCustomerJoinSale']);

    });
    Route::post('/tmp-upload', ['as' => 'image.tmp-upload', 'uses' => 'UploadController@tmpUpload']);

    Route::post('/tmp-upload-multiple', ['as' => 'image.tmp-upload-multiple', 'uses' => 'UploadController@tmpUploadMultiple']);
        
    Route::post('/update-order', ['as' => 'update-order', 'uses' => 'GeneralController@updateOrder']);
    Route::post('/update-status', ['as' => 'update-status', 'uses' => 'GeneralController@updateStatus']);
    Route::post('/ck-upload', ['as' => 'ck-upload', 'uses' => 'UploadController@ckUpload']);
    Route::post('/get-slug', ['as' => 'get-slug', 'uses' => 'GeneralController@getSlug']);

  
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', ['as' => 'account.index', 'uses' => 'AccountController@index']);
        Route::get('/ctv', ['as' => 'account.ctv', 'uses' => 'AccountController@ctv']);
        Route::get('/change-password', ['as' => 'account.change-pass', 'uses' => 'AccountController@changePass']);
        Route::post('/store-password', ['as' => 'account.store-pass', 'uses' => 'AccountController@storeNewPass']);
        Route::get('/update-status/{status}/{id}', ['as' => 'account.update-status', 'uses' => 'AccountController@updateStatus']);
        Route::get('/create', ['as' => 'account.create', 'uses' => 'AccountController@create']);
        Route::post('/store', ['as' => 'account.store', 'uses' => 'AccountController@store']);
        Route::get('{id}/edit',   ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
        Route::post('/update', ['as' => 'account.update', 'uses' => 'AccountController@update']);
        Route::get('{id}/destroy', ['as' => 'account.destroy', 'uses' => 'AccountController@destroy']);
    });

});