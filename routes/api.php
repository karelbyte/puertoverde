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

    Route::delete('products/file/delete/{id}', [ProductController::class, 'deleteFile']);

    Route::get('users/permissions/list', [UserController::class, 'getPermissionList']);
    Route::get('percents/default/{id}', [PercentController::class, 'setDefault']);
    Route::get('products/xls', [ProductController::class, 'export']);
    Route::get('settings/folio', [SettingController::class, 'getNextFolio']);
    Route::get('settings/current/change', [SettingController::class, 'getCurrentMoneyChange']);

    Route::post('prospect-services/create/client', [ProspectServiceController::class, 'createClient']);
    Route::post('products/file', [ProductController::class, 'storeFile']);

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
});


