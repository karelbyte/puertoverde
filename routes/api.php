<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MeasureController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\PercentController;
use App\Http\Controllers\ProspectServiceController;
use App\Http\Controllers\ClientGalleryController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryFixController;
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



Route::post('users/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::get('/backup', function () {
        \Illuminate\Support\Facades\Artisan::call('backup:run --only-db');
        return http_response_code(200);
    });

    Route::delete('products/file/delete/{id}', [ProductController::class, 'deleteFile']);

    Route::get('users/permissions/list', [UserController::class, 'getPermissionList']);
    Route::get('percents/default/{id}', [PercentController::class, 'setDefault']);
    Route::get('products/xls', [ProductController::class, 'export']);
    Route::get('settings/folio', [SettingController::class, 'getNextFolio']);
    Route::get('settings/current/change', [SettingController::class, 'getCurrentMoneyChange']);
    Route::get('settings/get/{key}', [SettingController::class, 'getSetting']);
    Route::get('receipts/inventories/{id}', [ReceiptController::class, 'setToInventories']);
    Route::get('inventories-fixes/inventories/{id}', [InventoryFixController::class, 'setToInventories']);
    Route::get('clients-services/inventories/{id}', [ClientServiceController::class, 'setToInventories']);

    Route::post('prospect-services/create/client', [ProspectServiceController::class, 'createClient']);
    Route::post('prospect-services/combine', [ProspectServiceController::class, 'combined']);
    Route::post('products/file', [ProductController::class, 'storeFile']);
    Route::post('products/price/add', [ProductController::class, 'addPriceToProduct']);

    Route::resource('clients', ClientController::class);
    Route::resource('prospect-services', ProspectServiceController::class);
    Route::resource('clients-gallery', ClientGalleryController::class);
    Route::resource('clients-services', ClientServiceController::class);
    Route::resource('providers', ProviderController::class);
    Route::resource('products', ProductController::class);
    Route::resource('measures', MeasureController::class);
    Route::resource('percents', PercentController::class);
    Route::resource('users', UserController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('receipts', ReceiptController::class);
    Route::resource('inventories-fixes', InventoryFixController::class);
    Route::resource('inventories', InventoryController::class);
});


