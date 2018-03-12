<?php
// Authentication routes...
Route::get('backend/login', ['as' => 'backend.login-form', 'uses' => 'Backend\UserController@loginForm']);
Route::post('backend/login', ['as' => 'backend.check-login', 'uses' => 'Backend\UserController@checkLogin']);
Route::get('backend/logout', ['as' => 'backend.logout', 'uses' => 'Backend\UserController@logout']);
Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'middleware' => 'isAdmin'], function()
{    

    Route::get('/data', ['as' => 'data', 'uses' => 'ReportController@data']);    
    
    Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => "SettingsController@dashboard"]);
    Route::group(['prefix' => 'compare'], function () {
        Route::get('/', ['as' => 'compare.index', 'uses' => 'CompareController@index']);
    });
    Route::group(['prefix' => 'hoa-hong'], function () {
        Route::get('/', ['as' => 'hh.index', 'uses' => 'HoaHongController@index']);
        Route::get('/change-csctv', ['as' => 'change-csctv', 'uses' => 'HoaHongController@csctv']);
        Route::post('/update-csctv', ['as' => 'update-cs', 'uses' => 'HoaHongController@updateCs']);
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index']);
        Route::post('/update', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
        Route::get('/noti', ['as' => 'settings.noti', 'uses' => 'SettingsController@noti']);        
        Route::post('/storeNoti', ['as' => 'settings.store-noti', 'uses' => 'SettingsController@storeNoti']);
    });
    Route::group(['prefix' => 'report'], function () {
        Route::get('/', ['as' => 'report.index', 'uses' => 'ReportController@index']);     
        Route::post('/search-price-other-site', ['as' => 'crawler.search-price-other-site', 'uses' => 'CompareController@search']);
    });
    Route::group(['prefix' => 'video'], function () {
        Route::get('/', ['as' => 'video.index', 'uses' => 'VideoController@index']);
        Route::get('/create', ['as' => 'video.create', 'uses' => 'VideoController@create']);
        Route::post('/store', ['as' => 'video.store', 'uses' => 'VideoController@store']);
        Route::get('{id}/edit',   ['as' => 'video.edit', 'uses' => 'VideoController@edit']);       
        Route::get('{id}/destroy', ['as' => 'video.destroy', 'uses' => 'VideoController@destroy']);
        Route::post('/update', ['as' => 'video.update', 'uses' => 'VideoController@update']);
    });
    Route::group(['prefix' => 'project'], function () {
        Route::get('/', ['as' => 'project.index', 'uses' => 'ProjectController@index']);
        Route::get('/create', ['as' => 'project.create', 'uses' => 'ProjectController@create']);
        Route::post('/store', ['as' => 'project.store', 'uses' => 'ProjectController@store']);
        Route::get('{id}/edit',   ['as' => 'project.edit', 'uses' => 'ProjectController@edit']);       
        Route::get('{id}/destroy', ['as' => 'project.destroy', 'uses' => 'ProjectController@destroy']);
        Route::post('/update', ['as' => 'project.update', 'uses' => 'ProjectController@update']);
    });
    Route::group(['prefix' => 'sales'], function () {
        Route::get('/', ['as' => 'sales.index', 'uses' => 'SalesController@index']);
        Route::get('/create', ['as' => 'sales.create', 'uses' => 'SalesController@create']);
        Route::post('/store', ['as' => 'sales.store', 'uses' => 'SalesController@store']);
        Route::get('{id}/edit',   ['as' => 'sales.edit', 'uses' => 'SalesController@edit']);     
        Route::get('{id}/detail',   ['as' => 'sales.detail', 'uses' => 'SalesController@detail']);       
        Route::get('{id}/destroy', ['as' => 'sales.destroy', 'uses' => 'SalesController@destroy']);
        Route::post('/update', ['as' => 'sales.update', 'uses' => 'SalesController@update']);
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
    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', ['as' => 'menu.index', 'uses' => 'GeneralController@setupMenu']);
        Route::get('/create', ['as' => 'menu.create', 'uses' => 'GeneralController@create']);
        Route::post('/store', ['as' => 'menu.store', 'uses' => 'GeneralController@storeMenu']);
        Route::get('{id}/edit',   ['as' => 'menu.edit', 'uses' => 'GeneralController@edit']);
        Route::post('/render-menu', ['as' => 'render-menu', 'uses' => 'GeneralController@renderMenu']);
        Route::get('{id}/destroy', ['as' => 'menu.destroy', 'uses' => 'GeneralController@destroy']);
    });
    Route::group(['prefix' => 'cart'], function () {
        Route::get('/', ['as' => 'cart.index', 'uses' => 'CartController@index']);
        Route::get('/create', ['as' => 'cart.create', 'uses' => 'CartController@create']);
        Route::post('/store', ['as' => 'cart.store', 'uses' => 'CartController@store']);
        Route::get('{id}/edit',   ['as' => 'cart.edit', 'uses' => 'CartController@edit']);
        Route::post('/update', ['as' => 'cart.update', 'uses' => 'CartController@update']);
        Route::get('{id}/destroy', ['as' => 'cart.destroy', 'uses' => 'CartController@destroy']);
    });
    Route::group(['prefix' => 'support'], function () {
        Route::get('/', ['as' => 'support.index', 'uses' => 'SupportController@index']);
        Route::get('/create', ['as' => 'support.create', 'uses' => 'SupportController@create']);
        Route::post('/store', ['as' => 'support.store', 'uses' => 'SupportController@store']);
        Route::get('{id}/edit',   ['as' => 'support.edit', 'uses' => 'SupportController@edit']);
        Route::post('/update', ['as' => 'support.update', 'uses' => 'SupportController@update']);
        Route::get('{id}/destroy', ['as' => 'support.destroy', 'uses' => 'SupportController@destroy']);
    });
    Route::group(['prefix' => 'work-group'], function () {
        Route::get('/', ['as' => 'work-group.index', 'uses' => 'WorkGroupController@index']);
        Route::get('/create', ['as' => 'work-group.create', 'uses' => 'WorkGroupController@create']);
        Route::post('/store', ['as' => 'work-group.store', 'uses' => 'WorkGroupController@store']);
        Route::get('{id}/edit',   ['as' => 'work-group.edit', 'uses' => 'WorkGroupController@edit']);
        Route::post('/update', ['as' => 'work-group.update', 'uses' => 'WorkGroupController@update']);
        Route::get('{id}/destroy', ['as' => 'work-group.destroy', 'uses' => 'WorkGroupController@destroy']);
    });
    Route::group(['prefix' => 'district'], function () {
        Route::get('/', ['as' => 'district.index', 'uses' => 'DistrictController@index']);
        Route::get('/create', ['as' => 'district.create', 'uses' => 'DistrictController@create']);
        Route::post('/store', ['as' => 'district.store', 'uses' => 'DistrictController@store']);
        Route::get('{id}/edit',   ['as' => 'district.edit', 'uses' => 'DistrictController@edit']);
        Route::post('/update', ['as' => 'district.update', 'uses' => 'DistrictController@update']);
        Route::get('{id}/destroy', ['as' => 'district.destroy', 'uses' => 'DistrictController@destroy']);
    });
    
    Route::group(['prefix' => 'cart-product'], function () {
        Route::get('/', ['as' => 'cart-product.index', 'uses' => 'CartProductController@index']);
        Route::get('/create', ['as' => 'cart-product.create', 'uses' => 'CartProductController@create']);
        Route::post('/store', ['as' => 'cart-product.store', 'uses' => 'CartProductController@store']);
        Route::get('{id}/edit',   ['as' => 'cart-product.edit', 'uses' => 'CartProductController@edit']);
        Route::post('/update', ['as' => 'cart-product.update', 'uses' => 'CartProductController@update']);
        Route::get('{id}/destroy', ['as' => 'cart-product.destroy', 'uses' => 'CartProductController@destroy']);
    });
    Route::group(['prefix' => 'user-work'], function () {
        Route::get('/', ['as' => 'user-work.index', 'uses' => 'UserWorkController@index']);
        Route::get('/create', ['as' => 'user-work.create', 'uses' => 'UserWorkController@create']);
        Route::post('/store', ['as' => 'user-work.store', 'uses' => 'UserWorkController@store']);
        Route::get('{id}/edit',   ['as' => 'user-work.edit', 'uses' => 'UserWorkController@edit']);
        Route::post('/update', ['as' => 'user-work.update', 'uses' => 'UserWorkController@update']);
        Route::get('{id}/destroy', ['as' => 'user-work.destroy', 'uses' => 'UserWorkController@destroy']);
    });
    Route::group(['prefix' => 'pages'], function () {
        Route::get('/', ['as' => 'pages.index', 'uses' => 'PagesController@index']);
        Route::get('/create', ['as' => 'pages.create', 'uses' => 'PagesController@create']);
        Route::post('/store', ['as' => 'pages.store', 'uses' => 'PagesController@store']);
        Route::get('{id}/edit',   ['as' => 'pages.edit', 'uses' => 'PagesController@edit']);
        Route::post('/update', ['as' => 'pages.update', 'uses' => 'PagesController@update']);
        Route::get('{id}/destroy', ['as' => 'pages.destroy', 'uses' => 'PagesController@destroy']);
    });
        Route::post('save-content', ['as' => 'save-content', 'uses' => "SettingsController@saveContent"]);
    Route::group(['prefix' => 'custom-link'], function () {
        Route::get('/', ['as' => 'custom-link.index', 'uses' => 'CustomLinkController@index']);
        Route::get('/create', ['as' => 'custom-link.create', 'uses' => 'CustomLinkController@create']);
        Route::post('/store', ['as' => 'custom-link.store', 'uses' => 'CustomLinkController@store']);
        Route::get('{id}/edit',   ['as' => 'custom-link.edit', 'uses' => 'CustomLinkController@edit']);
        Route::post('/update', ['as' => 'custom-link.update', 'uses' => 'CustomLinkController@update']);
        Route::get('{id}/destroy', ['as' => 'custom-link.destroy', 'uses' => 'CustomLinkController@destroy']);
    });
    Route::group(['prefix' => 'color'], function () {
        Route::get('/', ['as' => 'color.index', 'uses' => 'ColorController@index']);
        Route::get('/create', ['as' => 'color.create', 'uses' => 'ColorController@create']);
        Route::post('/store', ['as' => 'color.store', 'uses' => 'ColorController@store']);
        Route::get('{id}/edit',   ['as' => 'color.edit', 'uses' => 'ColorController@edit']);
        Route::post('/update', ['as' => 'color.update', 'uses' => 'ColorController@update']);
        Route::get('{id}/destroy', ['as' => 'color.destroy', 'uses' => 'ColorController@destroy']);
    });
    Route::group(['prefix' => 'customernoti'], function () {
        Route::get('/', ['as' => 'customernoti.index', 'uses' => 'CustomerNotificationController@index']);
        Route::get('/create', ['as' => 'customernoti.create', 'uses' => 'CustomerNotificationController@create']);
        Route::post('/store', ['as' => 'customernoti.store', 'uses' => 'CustomerNotificationController@store']);
        Route::get('{id}/edit',   ['as' => 'customernoti.edit', 'uses' => 'CustomerNotificationController@edit']);
        Route::post('/update', ['as' => 'customernoti.update', 'uses' => 'CustomerNotificationController@update']);
        Route::get('{id}/destroy', ['as' => 'customernoti.destroy', 'uses' => 'CustomerNotificationController@destroy']);
    });
    Route::group(['prefix' => 'info-seo'], function () {
        Route::get('/', ['as' => 'info-seo.index', 'uses' => 'InfoSeoController@index']);
        Route::get('/create', ['as' => 'info-seo.create', 'uses' => 'InfoSeoController@create']);
        Route::post('/store', ['as' => 'info-seo.store', 'uses' => 'InfoSeoController@store']);
        Route::get('{id}/edit',   ['as' => 'info-seo.edit', 'uses' => 'InfoSeoController@edit']);
        Route::post('/update', ['as' => 'info-seo.update', 'uses' => 'InfoSeoController@update']);
        Route::get('{id}/destroy', ['as' => 'info-seo.destroy', 'uses' => 'InfoSeoController@destroy']);
    });
    Route::group(['prefix' => 'newsletter'], function () {
        Route::get('/', ['as' => 'newsletter.index', 'uses' => 'NewsletterController@index']);
        Route::post('/store', ['as' => 'newsletter.store', 'uses' => 'NewsletterController@store']);
        Route::get('{id}/edit',   ['as' => 'newsletter.edit', 'uses' => 'NewsletterController@edit']);
        Route::get('/export',   ['as' => 'newsletter.export', 'uses' => 'NewsletterController@download']);
        Route::post('/update', ['as' => 'newsletter.update', 'uses' => 'NewsletterController@update']);
        Route::get('{id}/destroy', ['as' => 'newsletter.destroy', 'uses' => 'NewsletterController@destroy']);
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', ['as' => 'customer.index', 'uses' => 'CustomerController@index']);
        Route::post('/store', ['as' => 'customer.store', 'uses' => 'CustomerController@store']);
        Route::get('{id}/edit',   ['as' => 'customer.edit', 'uses' => 'CustomerController@edit']);
        Route::get('/export',   ['as' => 'customer.export', 'uses' => 'CustomerController@download']);
        Route::post('/update', ['as' => 'customer.update', 'uses' => 'CustomerController@update']);
        Route::get('{id}/destroy', ['as' => 'customer.destroy', 'uses' => 'CustomerController@destroy']);
        Route::get('{id}/join-sale-list', ['as' => 'customer.join-sale-list', 'uses' => 'CustomerController@joinSaleList']);
    });
    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', ['as' => 'contact.index', 'uses' => 'ContactController@index']);
        Route::post('/store', ['as' => 'contact.store', 'uses' => 'ContactController@store']);
        Route::get('{id}/edit',   ['as' => 'contact.edit', 'uses' => 'ContactController@edit']);
        Route::get('/export',   ['as' => 'contact.export', 'uses' => 'ContactController@download']);
        Route::post('/update', ['as' => 'contact.update', 'uses' => 'ContactController@update']);
        Route::get('{id}/destroy', ['as' => 'contact.destroy', 'uses' => 'ContactController@destroy']);
    });
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', ['as' => 'events.index', 'uses' => 'EventsController@index']);
        Route::get('/create', ['as' => 'events.create', 'uses' => 'EventsController@create']);
        Route::post('/store', ['as' => 'events.store', 'uses' => 'EventsController@store']);
        Route::get('{id}/edit',   ['as' => 'events.edit', 'uses' => 'EventsController@edit']);
        Route::post('/update', ['as' => 'events.update', 'uses' => 'EventsController@update']);
        Route::get('{id}/destroy', ['as' => 'events.destroy', 'uses' => 'EventsController@destroy']);
        Route::get('destroy-product/{event_id}/{sp_id}', ['as' => 'events.destroy-product', 'uses' => 'EventsController@destroyProduct']);
        Route::get('/product-event/{event_id}', ['as' => 'events.product-event', 'uses' => 'EventsController@productEvent']);
        Route::post('/ajax-search', ['as' => 'events.ajax-search', 'uses' => 'EventsController@ajaxSearch']);        
        Route::post('/ajax-save-product', ['as' => 'events.ajax-save-product', 'uses' => 'EventsController@ajaxSaveProduct']);
    });
    Route::group(['prefix' => 'tinh'], function () {
        Route::get('/', ['as' => 'tinh.index', 'uses' => 'TinhThanhController@index']);
        Route::post('/store', ['as' => 'tinh.store', 'uses' => 'TinhThanhController@store']);
        Route::get('{id}/edit',   ['as' => 'tinh.edit', 'uses' => 'TinhThanhController@edit']);
        Route::post('/update', ['as' => 'tinh.update', 'uses' => 'TinhThanhController@update']);
        Route::get('{id}/destroy', ['as' => 'tinh.destroy', 'uses' => 'TinhThanhController@destroy']);
    });
    Route::group(['prefix' => 'loai-sp'], function () {
        Route::get('/', ['as' => 'loai-sp.index', 'uses' => 'LoaiSpController@index']);
        Route::get('/create', ['as' => 'loai-sp.create', 'uses' => 'LoaiSpController@create']);
        Route::get('/thuoc-tinh', ['as' => 'loai-sp.thuoc-tinh', 'uses' => 'LoaiSpController@thuocTinh']);
        Route::get('/edit-thuoc-tinh', ['as' => 'loai-sp.edit-thuoc-tinh', 'uses' => 'LoaiSpController@editThuocTinh']);
        Route::get('/list-thuoc-tinh', ['as' => 'loai-sp.list-thuoc-tinh', 'uses' => 'LoaiSpController@listThuocTinh']);
        Route::post('/store-thuoc-tinh', ['as' => 'loai-sp.store-thuoc-tinh', 'uses' => 'LoaiSpController@storeThuocTinh']);
        Route::post('/update-thuoc-tinh', ['as' => 'loai-sp.update-thuoc-tinh', 'uses' => 'LoaiSpController@updateThuocTinh']);
        Route::post('/store', ['as' => 'loai-sp.store', 'uses' => 'LoaiSpController@store']);
        Route::get('{id}/edit',   ['as' => 'loai-sp.edit', 'uses' => 'LoaiSpController@edit']);
        Route::post('/update', ['as' => 'loai-sp.update', 'uses' => 'LoaiSpController@update']);
        Route::get('{id}/destroy', ['as' => 'loai-sp.destroy', 'uses' => 'LoaiSpController@destroy']);
        Route::get('{id}/destroy-thuoc-tinh', ['as' => 'loai-sp.destroyThuocTinh', 'uses' => 'LoaiSpController@destroyThuocTinh']);
    });
    Route::group(['prefix' => 'estate-type'], function () {
        Route::get('/', ['as' => 'estate-type.index', 'uses' => 'EstateTypeController@index']);
        Route::get('/create', ['as' => 'estate-type.create', 'uses' => 'EstateTypeController@create']);       
        Route::post('/store', ['as' => 'estate-type.store', 'uses' => 'EstateTypeController@store']);
        Route::get('{id}/edit',   ['as' => 'estate-type.edit', 'uses' => 'EstateTypeController@edit']);
        Route::post('/update', ['as' => 'estate-type.update', 'uses' => 'EstateTypeController@update']);
        Route::get('{id}/destroy', ['as' => 'estate-type.destroy', 'uses' => 'EstateTypeController@destroy']);        
    });
    Route::group(['prefix' => 'convert'], function () {
        Route::get('/', ['as' => 'convert.index', 'uses' => 'ConvertController@index']);
    });
    Route::group(['prefix' => 'loai-thuoc-tinh'], function () {
        Route::get('/', ['as' => 'loai-thuoc-tinh.index', 'uses' => 'LoaiThuocTinhController@index']);
        Route::get('/create', ['as' => 'loai-thuoc-tinh.create', 'uses' => 'LoaiThuocTinhController@create']);
        Route::post('/store', ['as' => 'loai-thuoc-tinh.store', 'uses' => 'LoaiThuocTinhController@store']);

        Route::get('{id}/edit',   ['as' => 'loai-thuoc-tinh.edit', 'uses' => 'LoaiThuocTinhController@edit']);
        Route::post('/update', ['as' => 'loai-thuoc-tinh.update', 'uses' => 'LoaiThuocTinhController@update']);
        Route::get('{id}/destroy', ['as' => 'loai-thuoc-tinh.destroy', 'uses' => 'LoaiThuocTinhController@destroy']);
        Route::get('/ajax-get-loai-thuoc-tinh-by-id', ['as' => 'loai-thuoc-tinh.ajax-get-loai-thuoc-tinh-by-id', 'uses' => 'LoaiThuocTinhController@getLoaiThuocTinhByLoaiId']);
    });
    Route::group(['prefix' => 'thuoc-tinh'], function () {
        Route::get('/', ['as' => 'thuoc-tinh.index', 'uses' => 'ThuocTinhController@index']);
        Route::get('/create', ['as' => 'thuoc-tinh.create', 'uses' => 'ThuocTinhController@create']);
        Route::post('/store', ['as' => 'thuoc-tinh.store', 'uses' => 'ThuocTinhController@store']);
        Route::get('{id}/edit',   ['as' => 'thuoc-tinh.edit', 'uses' => 'ThuocTinhController@edit']);
        Route::post('/update', ['as' => 'thuoc-tinh.update', 'uses' => 'ThuocTinhController@update']);
        Route::get('{id}/destroy', ['as' => 'thuoc-tinh.destroy', 'uses' => 'ThuocTinhController@destroy']);
    });
    Route::group(['prefix' => 'cate'], function () {
        Route::get('/', ['as' => 'cate.index', 'uses' => 'CateController@index']);
        Route::get('/create/', ['as' => 'cate.create', 'uses' => 'CateController@create']);
        Route::post('/store', ['as' => 'cate.store', 'uses' => 'CateController@store']);
        Route::get('{id}/edit',   ['as' => 'cate.edit', 'uses' => 'CateController@edit']);
        Route::post('/update', ['as' => 'cate.update', 'uses' => 'CateController@update']);
        Route::get('{id}/destroy', ['as' => 'cate.destroy', 'uses' => 'CateController@destroy']);
    });
    Route::group(['prefix' => 'banner'], function () {
        Route::get('/', ['as' => 'banner.index', 'uses' => 'BannerController@index']);
        Route::get('/create/', ['as' => 'banner.create', 'uses' => 'BannerController@create']);
        Route::get('/list', ['as' => 'banner.list', 'uses' => 'BannerController@lists']);
        Route::post('/store', ['as' => 'banner.store', 'uses' => 'BannerController@store']);
        Route::get('/edit',   ['as' => 'banner.edit', 'uses' => 'BannerController@edit']);
        Route::post('/update', ['as' => 'banner.update', 'uses' => 'BannerController@update']);
        Route::get('{id}/destroy', ['as' => 'banner.destroy', 'uses' => 'BannerController@destroy']);
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

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', ['as' => 'orders.index', 'uses' => 'OrderController@index']);
        Route::post('/update', ['as' => 'orders.update', 'uses' => 'OrderController@update']);
        Route::get('/{order_id}/chi-tiet', ['as' => 'order.detail', 'uses' => 'OrderController@orderDetail']);
        Route::post('/delete-order-detail', ['as' => 'order.detail.delete', 'uses' => 'OrderController@orderDetailDelete']);
    });

     Route::group(['prefix' => 'articles-cate'], function () {
        Route::get('/', ['as' => 'articles-cate.index', 'uses' => 'ArticlesCateController@index']);
        Route::get('/create', ['as' => 'articles-cate.create', 'uses' => 'ArticlesCateController@create']);
        Route::post('/store', ['as' => 'articles-cate.store', 'uses' => 'ArticlesCateController@store']);
        Route::get('{id}/edit',   ['as' => 'articles-cate.edit', 'uses' => 'ArticlesCateController@edit']);
        Route::post('/update', ['as' => 'articles-cate.update', 'uses' => 'ArticlesCateController@update']);
        Route::get('{id}/destroy', ['as' => 'articles-cate.destroy', 'uses' => 'ArticlesCateController@destroy']);
    });
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/', ['as' => 'tag.index', 'uses' => 'TagController@index']);
        Route::get('/create', ['as' => 'tag.create', 'uses' => 'TagController@create']);
        Route::post('/store', ['as' => 'tag.store', 'uses' => 'TagController@store']);
        Route::post('/ajaxSave', ['as' => 'tag.ajax-save', 'uses' => 'TagController@ajaxSave']);  
        Route::get('/ajax-list', ['as' => 'tag.ajax-list', 'uses' => 'TagController@ajaxList']);      
        Route::get('{id}/edit',   ['as' => 'tag.edit', 'uses' => 'TagController@edit']);
        Route::post('/update', ['as' => 'tag.update', 'uses' => 'TagController@update']);
        Route::get('{id}/destroy', ['as' => 'tag.destroy', 'uses' => 'TagController@destroy']);
    });
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
    Route::group(['prefix' => 'articles'], function () {
        Route::get('/', ['as' => 'articles.index', 'uses' => 'ArticlesController@index']);
        Route::get('/create', ['as' => 'articles.create', 'uses' => 'ArticlesController@create']);
        Route::post('/store', ['as' => 'articles.store', 'uses' => 'ArticlesController@store']);
        Route::get('{id}/edit',   ['as' => 'articles.edit', 'uses' => 'ArticlesController@edit']);
        Route::post('/update', ['as' => 'articles.update', 'uses' => 'ArticlesController@update']);
        Route::get('{id}/destroy', ['as' => 'articles.destroy', 'uses' => 'ArticlesController@destroy']);
    });
     Route::group(['prefix' => 'landing-projects'], function () {
        Route::get('/', ['as' => 'landing-projects.index', 'uses' => 'LandingProjectsController@index']);
        Route::get('/create', ['as' => 'landing-projects.create', 'uses' => 'LandingProjectsController@create']);
        Route::post('/store', ['as' => 'landing-projects.store', 'uses' => 'LandingProjectsController@store']);
        Route::get('{id}/edit',   ['as' => 'landing-projects.edit', 'uses' => 'LandingProjectsController@edit']);
        Route::post('/update', ['as' => 'landing-projects.update', 'uses' => 'LandingProjectsController@update']);
        Route::get('{id}/destroy', ['as' => 'landing-projects.destroy', 'uses' => 'LandingProjectsController@destroy']);
    });
     Route::group(['prefix' => 'pro-content'], function () {
        Route::get('/', ['as' => 'pro-content.index', 'uses' => 'ProContentController@index']);
        Route::get('/create', ['as' => 'pro-content.create', 'uses' => 'ProContentController@create']);
        Route::post('/store', ['as' => 'pro-content.store', 'uses' => 'ProContentController@store']);
        Route::get('{id}/edit',   ['as' => 'pro-content.edit', 'uses' => 'ProContentController@edit']);
        Route::post('/update', ['as' => 'pro-content.update', 'uses' => 'ProContentController@update']);
        Route::get('{id}/destroy', ['as' => 'pro-content.destroy', 'uses' => 'ProContentController@destroy']);
    });

});