<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['prefix' => ''], function () {
    Route::get('create', function () {

        return view('welcome');
    });
    Route::group(['prefix' => 'products'], function () {
        Route::put('', 'ProductController@create')->name('products.create');
        Route::get('create', function () {
            $data['products'] = [];
            $productPath = 'products.json';
            if (file_exists($productPath)) {
                $data['products'] = explode('|', file_get_contents($productPath));
            }

            return view('products.create', $data);
        });
    });
});
