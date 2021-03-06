<?php
use think\Route;

Route::get('api/:version/banner/:id' , 'api/:version.Banner/getBanner');

Route::get('api/:version/theme' , 'api/:version.Theme/getSimpleList');
Route::get('api/:version/theme/:id' , 'api/:version.Theme/getComplexOne');

Route::group('api/:version/product', function (){
    Route::get('/recent' , 'api/:version.Product/getRecent');
    Route::get('/by_category' , 'api/:version.Product/getAllInCategory');
    Route::get('/:id' , 'api/:version.Product/getOne',[],['id'=>'\d+']);
});

Route::get('api/:version/category/all' , 'api/:version.Category/getAllCategories');

Route::post('api/:version/token/user' , 'api/:version.Token/getToken');

Route::post('api/:version/address' , 'api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order' , 'api/:version.Order/placeOrder');
Route::post('api/:version/order/:id' , 'api/:version.Order/getDetail',[],['id'=>'\d+']);
Route::post('api/:version/order/bu_user' , 'api/:version.Order/getSummaryByUser');

Route::post('api/:version/pay/pre_order' , 'api/:version.Pay/getPreOrder');

Route::post('api/:version/pay/notify' , 'api/:version.Pay/receiveNotify');

Route::post('api/:version/pay/re_notify' , 'api/:version.Pay/redirectNotify');