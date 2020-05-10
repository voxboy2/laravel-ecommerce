<?php

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




    // Frontend routes

    Route::get('/', 'IndexController@index');



    Route::get('/products/{url}', 'ProductController@products');

    Route::get('product/{id}', 'ProductController@product');


    Route::get('/get-product-price', 'ProductController@getProductPrice');
    
    



Route::group(['middleware'=>['frontlogin']], function(){
   // users Account 
   Route::match(['get', 'post'], '/account', 'UsersController@account')->name('account');
   Route::get('/check-user-pwd', 'UsersController@chkUserPassword');
   Route::post('/update-user-pwd', 'UsersController@updatePassword');

   //check-out
   Route::match(['get','post'], 'checkout', 'ProductController@checkout')->name('checkout');
   Route::match(['get','post'], '/order-review', 'ProductController@orderReview')->name('orderReview');
   Route::match(['get','post'], '/place-order', 'ProductController@placeOrder')->name('placeorder');
   Route::get('/thanks', 'ProductController@thanks')->name('thanks');
   Route::get('/paystack', 'ProductController@paystack')->name('paystack'); 

   Route::post('/pay', 'ProductController@redirectToGateway')->name('pay'); 
   Route::get('/payment/callback', 'ProductController@handleGatewayCallback');


   Route::get('/orders', 'ProductController@userOrders')->name('orders');
   Route::get('/orders/{id}','ProductController@userOrderDetails');

   
   //    Cart Routes
   Route::match(['get', 'post'], '/add-cart', 'ProductController@addtoCart');
   Route::match(['get', 'post'], '/cart', 'ProductController@cart')->name('cart');
   Route::get('/cart/delete-product/{id}', 'ProductController@deleteCartProduct')->name('deletecart');
   Route::get('/cart/update-quantity/{id}/{quantity}','ProductController@updateCartQuantity')->name('updatecart');

   Route::get('/user-logout', 'UsersController@logout')->name('user_logout');




});

Route::match(['get', 'post'],'forgot-password', 'UsersController@forgotPassword')->name('forgot-password');

// Register Routes
Route::get('/login-register', 'UsersController@userLoginRegister')->name('login_page');
Route::match(['get','post'], '/check-email', 'UsersController@checkEmail');
Route::post('/user-register', 'UsersController@register')->name('user_register');
Route::get('confirm/{code}', 'UsersController@confirmAccount');
Route::post('user-login','UsersController@login')->name('user_login'); 