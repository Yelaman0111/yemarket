<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {

    Route::get('categories', [App\Http\Controllers\Api\PublicController::class, 'getCategories'])->name('getCategories');
    Route::get('products/categories/{id}', [App\Http\Controllers\Api\PublicController::class, 'getProductsByCategory']);
    Route::get('products/brands/{id}', [App\Http\Controllers\Api\PublicController::class, 'getProductsByBrand']);
    Route::get('products/company/{id}', [App\Http\Controllers\Api\PublicController::class, 'getProductsByCompany']);
    Route::post('products/search', [App\Http\Controllers\Api\PublicController::class, 'searchProducts']);
    Route::get('corousel', [App\Http\Controllers\Api\PublicController::class, 'getCorousel']);
    Route::get('companies/all',  [App\Http\Controllers\Api\PublicController::class, 'getCompaniesForMainPage'])->name('getCompaniesForMainPage');


    Route::group(['prefix' => 'admin'], function () {

        Route::post('login', [App\Http\Controllers\Api\UserController::class, 'userLogin'])->name('userLogin');
        // Route::post('registration', [App\Http\Controllers\Api\UserController::class, 'store'])->name('userRegistration');

        Route::group(['middleware' => 'user:user-api'], function () {
            Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);
            Route::post('companies/{id}/block', [\App\Http\Controllers\Api\UserController::class, 'blockCompany']);
            Route::get('companies/{id}/products', [\App\Http\Controllers\Api\UserController::class, 'getCompaniesProducts']);
            Route::get('companies/{id}/orders', [\App\Http\Controllers\Api\UserController::class, 'getCompaniesOrders']);
            Route::post('companies/products/{id}', [\App\Http\Controllers\Api\UserController::class, 'approveCompaniesProducts']);
            Route::get('companies', [\App\Http\Controllers\Api\UserController::class, 'getAllCompanies']);
            Route::post('shops/{id}/block', [\App\Http\Controllers\Api\UserController::class, 'blockShop']);
            Route::get('shops/{id}/orders', [\App\Http\Controllers\Api\UserController::class, 'getShopOrders']);
            Route::get('shops', [\App\Http\Controllers\Api\UserController::class, 'getAllShops']);
            Route::post('categories/create', [\App\Http\Controllers\Api\UserController::class, 'createCategory']);
            Route::post('categories/{id}', [\App\Http\Controllers\Api\UserController::class, 'updateCategory']);
            Route::get('categories', [\App\Http\Controllers\Api\UserController::class, 'getAllCategories']);
            Route::post('brands/create', [\App\Http\Controllers\Api\UserController::class, 'createBrand']);
            Route::post('brands/{id}', [\App\Http\Controllers\Api\UserController::class, 'updateBrand']);
            Route::get('brands', [\App\Http\Controllers\Api\UserController::class, 'getBrands']);
            Route::get('parentcategories', [\App\Http\Controllers\Api\UserController::class, 'getParentCategories']);
            Route::post('products/{id}/approve', [\App\Http\Controllers\Api\UserController::class, 'approveProduct']);
            Route::get('products', [\App\Http\Controllers\Api\UserController::class, 'getProducts']);
        });
    });

    Route::group(['prefix' => 'company'], function () {

        Route::post('login', [App\Http\Controllers\Api\CompanyController::class, 'companyLogin'])->name('companyLogin');
        Route::post('registration', [App\Http\Controllers\Api\CompanyController::class, 'store'])->name('companyRegistration');

        Route::group(['middleware' => 'company:companies-api'], function () {
            Route::get('show', [App\Http\Controllers\Api\CompanyController::class, 'show']);
            Route::post('update', [App\Http\Controllers\Api\CompanyController::class, 'update']);
            Route::get('categories', [App\Http\Controllers\Api\CompanyController::class, 'getAllCategories']);
            Route::get('brands', [App\Http\Controllers\Api\CompanyController::class, 'getAllBrands']);
            Route::post('products/create', [App\Http\Controllers\Api\CompanyController::class, 'storeProduct']);
            Route::post('products/connect', [App\Http\Controllers\Api\CompanyController::class, 'connectToProduct']);
            Route::post('products/search', [App\Http\Controllers\Api\CompanyController::class, 'searchProductOfCompany']);
            Route::post('products/all/search', [App\Http\Controllers\Api\CompanyController::class, 'searchProductForConnect']);
            Route::get('products/all', [App\Http\Controllers\Api\CompanyController::class, 'getApprovedProductsWithoutCompanyProducts']);
            Route::get('products', [App\Http\Controllers\Api\CompanyController::class, 'getCompanyAllProducts']);
            Route::post('orders/accept', [App\Http\Controllers\Api\CompanyController::class, 'ordersAccept']);
            Route::get('orders/download/{order_id}', [App\Http\Controllers\Api\CompanyController::class, 'downloadOrder']);
            Route::get('orders', [App\Http\Controllers\Api\CompanyController::class, 'getCompanyOrders']);
        });
    });

    Route::group(['prefix' => 'shop'], function () {

        Route::post('login', [App\Http\Controllers\Api\ShopController::class, 'shopLogin'])->name('shopLogin');
        Route::post('registration', [App\Http\Controllers\Api\ShopController::class, 'store'])->name('shopRegistration');

        Route::group(['middleware' => 'shop:shop-api'], function () {
            Route::get('show', [App\Http\Controllers\Api\ShopController::class, 'show']);
            Route::post('update', [App\Http\Controllers\Api\ShopController::class, 'update']);
            Route::post('destroy', [App\Http\Controllers\Api\ShopController::class, 'destroy']);

            Route::post('orders', [App\Http\Controllers\Api\ShopController::class, 'storeOrder']);
            Route::get('orders', [App\Http\Controllers\Api\ShopController::class, 'getOrders']);
            // Route::get('orders/{order_id}', [App\Http\Controllers\Api\ShopController::class, 'getOrder']);
            Route::get('orders/{id}/cancel', [App\Http\Controllers\Api\ShopController::class, 'cancelOrder']);
            Route::get('orders/{id}/confirmdelivery', [App\Http\Controllers\Api\ShopController::class, 'confirmDeliveryOrder']);
        });
    });
});
