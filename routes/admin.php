<?php

Route::group(['middleware' => ['adminlogin']], function(){
    Route::get('admin/dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::get('/admin/settings', 'AdminController@settings')->name('change-password');
    Route::get('/admin/check-pwd', 'AdminController@chkPassword');
    Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword');

    // category routes
    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::get('/admin/view-categories', 'CategoryController@viewCategories');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory');
    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory');

    // product routes
    Route::match(['get', 'post'], '/admin/add-product', 'ProductController@addProduct');
    Route::match(['get','post'],'/admin/edit-product/{id}','ProductController@editProduct');
    Route::get('/admin/view-products', 'ProductController@viewProducts');
    Route::get('/admin/delete-product-image/{id}', 'ProductController@deleteProductImage');
    Route::get('/admin/delete-product/{id}', 'ProductController@deleteProduct');
   
    // product attribute routes
    Route::match(['get', 'post'], 'admin/add-attributes/{id}', 'ProductController@addAttributes');
    Route::get('/admin/delete-attribute/{id}', 'ProductController@deleteAttribute');
    Route::match(['get', 'post'], 'admin/edit-attributes/{id}', 'ProductController@editAttributes');


    // product images
    Route::match(['get', 'post'], 'admin/add-images/{id}', 'ProductController@addImages');
    Route::get('/admin/delete-alt-image/{id}', 'ProductController@deleteAltImage');




    //  Coupon Routes
    Route::match(['get', 'post'], '/admin/add-coupon', 'CouponsController@addCoupon');
    Route::get('/admin/view-coupons', 'CouponsController@viewCoupons')->name('viewcoupons');
    Route::match(['get', 'post'], '/admin/edit-coupon/{id}', 'CouponsController@editCoupon');
    Route::get('/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon')->name('del_coupons');
    Route::post('/cart/apply-coupon', 'ProductController@applyCoupon')->name('applycoupon');

    // Banner Routes
    Route::match(['get', 'post'], '/admin/add-banner', 'BannersController@addBanner');
    Route::get('/admin/view-banners', 'BannersController@viewBanners');
    Route::match(['get','post'], '/admin/edit-banner/{id}', 'BannersController@editBanner');
    Route::get('/admin/delete-banner/{id}', 'BannersController@deleteBanner');


    // Admin Orders Routes
    Route::get('/admin/view-orders', 'ProductController@viewOrders');
    Route::get('/admin/view-order/{id}', 'ProductController@viewOrderDetails');
    Route::post('/admin/update-order-status', 'ProductController@updateOrderStatus');

});


  // login routes   
  Route::match(['get', 'post'], '/admin','AdminController@login')->name('login');
  Route::get('/logout', 'AdminController@logout')->name('logout');