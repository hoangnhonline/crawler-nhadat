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



Route::group(['prefix' => 'social-auth'], function () {
    Route::group(['prefix' => 'facebook'], function () {
        Route::get('redirect/', ['as' => 'fb-auth', 'uses' => 'SocialAuthController@redirect']);
        Route::get('callback/', ['as' => 'fb-callback', 'uses' => 'SocialAuthController@callback']);
        Route::post('fb-login', ['as' => 'ajax-login-by-fb', 'uses' => 'SocialAuthController@fbLogin']);
    });

    Route::group(['prefix' => 'google'], function () {
        Route::get('redirect/', ['as' => 'gg-auth', 'uses' => 'SocialAuthController@googleRedirect']);
        Route::get('callback/', ['as' => 'gg-callback', 'uses' => 'SocialAuthController@googleCallback']);
    });

});

Route::group(['prefix' => 'authentication'], function () {
    Route::post('check_login', ['as' => 'auth-login', 'uses' => 'AuthenticationController@checkLogin']);
    Route::post('login_ajax', ['as' =>  'auth-login-ajax', 'uses' => 'AuthenticationController@checkLoginAjax']);
    Route::get('/user-logout', ['as' => 'user-logout', 'uses' => 'AuthenticationController@logout']);
});
Route::group(['namespace' => 'Frontend'], function()
{
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/nha-dat-ban', ['as' => 'ban', 'uses' => 'ProductController@ban']);
    Route::get('/nha-dat-cho-thue', ['as' => 'cho-thue', 'uses' => 'ProductController@choThue']);
    Route::post('/project-contact', ['as' => 'project-contact', 'uses' => 'ProjectsController@contact']);
    
    Route::get('/du-an', ['as' => 'du-an', 'uses' => 'ProjectsController@index']);    
    Route::post('/send-contact', ['as' => 'send-contact', 'uses' => 'ContactController@store']);
    Route::get('/tai-khoan/khoa-hoc-cua-toi', ['as' => 'khoa-hoc-cua-toi', 'uses' => 'CustomerController@courses']);
    Route::get('/tai-khoan/xem-thong-tin', ['as' => 'xem-thong-tin', 'uses' => 'CustomerController@accountInfo']); 
    Route::get('thong-tin-tai-khoan', ['as' => 'account-info', 'uses' => 'CustomerController@accountInfo']);
    Route::get('doi-mat-khau', ['as' => 'change-password', 'uses' => 'CustomerController@changePassword']);
    Route::get('du-an/{slug}', ['as' => 'detail-project', 'uses' => 'ProjectsController@detail']);
    Route::get('du-an/{slug}/{slugtab}', ['as' => 'tab', 'uses' => 'ProjectsController@tab']);
    Route::post('/tmp-upload-multiple-fe', ['as' => 'image.tmp-upload-multiple-fe', 'uses' => 'UploadController@tmpUploadMultipleFE']);
   
    Route::get('tag/{slug}', ['as' => 'tag', 'uses' => 'DetailController@tagDetail']);
    Route::get('tin-tuc/{slug}', ['as' => 'news-list', 'uses' => 'NewsController@newsList']);
    Route::get('{slug_type}/{slug}', ['as' => 'danh-muc-con', 'uses' => 'ProductController@cateChild']);
    Route::get('{slugLoaiSp}/{slug}-{id}.html', ['as' => 'chi-tiet', 'uses' => 'DetailController@index']);
    
    Route::get('/tin-tuc/{slug}-p{id}.html', ['as' => 'news-detail', 'uses' => 'NewsController@newsDetail']);
    

    Route::get('/dang-tin-ky-gui.html', ['as' => 'ky-gui', 'uses' => 'DetailController@kygui']);
    Route::get('/dang-tin-thanh-cong.html', ['as' => 'ky-gui-thanh-cong', 'uses' => 'DetailController@kyguiSuccess']);    
    Route::post('/post-ky-gui', ['as' => 'post-ky-gui', 'uses' => 'DetailController@postKygui']);    

    Route::post('/dang-ki-newsletter', ['as' => 'register.newsletter', 'uses' => 'HomeController@registerNews']);    
    Route::post('/get-district', ['as' => 'get-district', 'uses' => 'DistrictController@getDistrict']);
    Route::post('/get-ward', ['as' => 'get-ward', 'uses' => 'WardController@getWard']);   
    Route::get('/tim-kiem.html', ['as' => 'search', 'uses' => 'ProductController@search']);
    Route::get('so-sanh.html', ['as' => 'so-sanh', 'uses' => 'CompareController@index']);
    Route::get('lien-he.html', ['as' => 'contact', 'uses' => 'HomeController@contact']);
    Route::get('{slug}.html', ['as' => 'danh-muc', 'uses' => 'ProductController@cate']);
    
    Route::get('{slugCateParent}/{slugCateChild}', ['as' => 'cate', 'uses' => 'CateController@cateChild']);
    
    Route::post('/customer/update', ['as' => 'update-customer', 'uses' => 'CustomerController@update']);
    
    Route::post('/customer/register', ['as' => 'register-customer', 'uses' => 'CustomerController@register']);
    Route::post('/customer/register-ajax', ['as' => 'register-customer-ajax', 'uses' => 'CustomerController@registerAjax']);
    Route::post('/customer/checkemail', ['as' => 'checkemail-customer', 'uses' => 'CustomerController@isEmailExist']);
    Route::post('/customer/join-sale', ['as' => 'customer-join-sale', 'uses' => 'CustomerController@joinSale']);
    Route::get('/webctv/{idctv}/idpro', ['as' => 'web-ctv', 'uses' => 'WebctvController@webctv']);

});

