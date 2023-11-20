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

    use Illuminate\Support\Facades\Route;
    use Modules\YanakSoftApi\Http\Controllers\YanakSettingsController;
    use Modules\YanakSoftApi\Http\Controllers\YanakSoftProductController;

    Route::prefix('system/apis/yanaksoftapi')->group(function () {
        Route::get('/getToken', 'YanakSoftApiController@getToken');
        Route::get('/getAllStocks', 'YanakSoftApiController@getAllStocks');
        Route::get('/getAllCategories', 'YanakSoftApiController@getAllCategories');
        Route::get('/getAllCustomers', 'YanakSoftApiController@getAllCustomers');
        Route::get('/addStockToCart', 'YanakSoftApiController@addStockToCart');
        Route::get('/editStockFromCart', 'YanakSoftApiController@editStockFromCart');
        Route::get('/deleteStockFromCart', 'YanakSoftApiController@deleteStockFromCart');
        Route::get('/showStocksInCart', 'YanakSoftApiController@showStocksInCart');
        Route::get('/showStocksInCart', 'YanakSoftApiController@showStocksInCart');
        Route::get('/makeOrderToYanakSoft', 'YanakSoftApiController@makeOrderToYanakSoft');

        /* Products */
        Route::group(['prefix' => 'products'], static function () {
            Route::get('update-products', [YanakSoftProductController::class, 'updateProducts'])->name('admin.shop.settings.internal-integrations.yanak.products.update');
        });

        /* Settings */
        Route::group(['prefix' => 'settings'], static function () {
            Route::get('index', [YanakSettingsController::class, 'index'])->name('admin.shop.settings.internal-integrations.yanak.index');
            Route::post('update', [YanakSettingsController::class, 'update'])->name('admin.shop.settings.internal-integrations.yanak.update');
        });
    });
