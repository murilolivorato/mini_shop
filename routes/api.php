<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/admin/post-login',  [ 'uses'        => 'App\Http\Controllers\AdminAuthController@postLogin']);
Route::post('/admin/logout',      [ 'uses'        => 'App\Http\Controllers\AdminAuthController@getLogout']);


Route::group(['middleware' => ['auth:user_admin']] , function() {
    Route::post('/admin/info' ,                                        [ 'uses'        => 'App\Http\Controllers\AdminAuthController@info' ]);


    /* --------------------------------------------------------------------------------------------  PRODUCT
  -------------------------------------------------------------------------------------------------------------  */

    // PRODUCT
    Route::post('admin/product/store'                 , ['uses' => 'App\Http\Controllers\Admin\ProductController@store']);
    Route::post('admin/product/update/{id}'           , ['uses' => 'App\Http\Controllers\Admin\ProductController@update']);
    Route::post('admin/product/upload-images'         , ['uses' => 'App\Http\Controllers\Admin\ProductController@upload_image' ]);
    Route::get('admin/product/load-display'           , ['uses' => 'App\Http\Controllers\Admin\ProductController@load_display']);
    Route::get('admin/product/load-form-options'      , ['uses' => 'App\Http\Controllers\Admin\ProductController@load_form_options']);
    Route::post('admin/product/destroy'               , ['uses' => 'App\Http\Controllers\Admin\ProductController@destroy']);
    Route::get('admin/product/load-form/{id}'         , ['uses' => 'App\Http\Controllers\Admin\ProductController@load_form']);
    Route::get('admin/product/load-sub-category/{id}' , ['uses' => 'App\Http\Controllers\Admin\ProductController@load_sub_category']);



    // PRODUCT CATEGORY
    Route::post('admin/product-category/store'                 , ['uses' => 'App\Http\Controllers\Admin\ProductCategoryController@store']);
    Route::post('admin/product-category/update/{id}'           , ['uses' => 'App\Http\Controllers\Admin\ProductCategoryController@update']);
    Route::get('admin/product-category/load-display'           , ['uses' => 'App\Http\Controllers\Admin\ProductCategoryController@load_display']);
    Route::post('admin/product-category/upload-images'         , [ 'uses' => 'App\Http\Controllers\Admin\ProductCategoryController@upload_images' ]);
    Route::post('admin/product-category/destroy'               , ['uses' => 'App\Http\Controllers\Admin\ProductCategoryController@destroy']);
    Route::get('admin/product-category/load-form/{id}'         , ['uses' => 'App\Http\Controllers\Admin\ProductCategoryController@load_form' ]);

    // PRODUCT SUB CATEGORY
    Route::post('admin/product-sub-category/store'                 , ['uses'  => 'App\Http\Controllers\Admin\ProductSubCategoryController@store']);
    Route::post('admin/product-sub-category/update/{id}'           , ['uses'  => 'App\Http\Controllers\Admin\ProductSubCategoryController@update']);
    Route::get('admin/product-sub-category/load-display'           , ['uses'  => 'App\Http\Controllers\Admin\ProductSubCategoryController@load_display']);
    Route::post('admin/product-sub-category/upload-images'         , [ 'uses' => 'App\Http\Controllers\Admin\ProductSubCategoryController@upload_images' ]);
    Route::get('admin/product-sub-category/load-form-options'      , ['uses'  => 'App\Http\Controllers\Admin\ProductSubCategoryController@load_form_options']);
    Route::post('admin/product-sub-category/destroy'               , ['uses'  => 'App\Http\Controllers\Admin\ProductSubCategoryController@destroy']);
    Route::get('admin/product-sub-category/load-form/{id}'         , ['uses'  => 'App\Http\Controllers\Admin\ProductSubCategoryController@load_form']);


    /* ------------------------------------------------------------------------------------------------      IMAGE GALLERY
    -------------------------------------------------------------------------------------------------------------  */
    Route::post('admin/image-gallery/upload-image'          , ['uses'        => 'App\Http\Controllers\Admin\ImageGalleryController@upload_image' ]);


});


// PASSWORD
Route::post('/password/post-reset'                        , [ 'uses'        => 'App\Http\Controllers\ForgotPassController@postResetPass' ]);
Route::get('/password/load-form-recover-pass/{token}'     , [ 'uses'        => 'App\Http\Controllers\ForgotPassController@loadFormPasswordReset' ]);
Route::post('/password/post-recover'                      , [ 'uses'        => 'App\Http\Controllers\ForgotPassController@postRecoverPass' ]);

/*Route::middleware('auth:api')->get('/customer/info' ,                 [ 'uses'        => 'CustomerAuthController@info' ]);*/


Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
