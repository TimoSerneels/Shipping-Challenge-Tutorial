<?php

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::view('/','home');
Route::get('shop', 'ShopController@index');
Route::get('shop/{id}', 'ShopController@show');
Route::get('shop_alt', 'Shop_altController@index');

//Contact
Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');

Route::redirect('admin', 'admin/records');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    route::redirect('/', 'records');
    Route::get('records', 'Admin\RecordController@index');
});

Route::redirect('user', '/user/profile');
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('profile', 'User\ProfileController@edit');
    Route::post('profile', 'User\ProfileController@update');
});

//New version with prefix and group
//Route::prefix('admin')->group(function () {
////    Route::get('records', function (){
////        $records = [
////            'Queen - Greatest Hits',
////            'The Rolling Stones - Sticky Fingers',
////            'The Beatles - Abbey Road'
////        ];
////        return view('admin.records.index', [
////            'records' => $records
////        ]);
////    });
////});
////
////Route::prefix('admin')->group(function () {
////    Route::redirect('/', 'records');
////    Route::get('records', 'Admin\RecordController@index');
////});
