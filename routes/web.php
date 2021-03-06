<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\ProspectServiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryFixController;
use App\Http\Controllers\OrderController;
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

Route::get('/page-pay', [ClientServiceController::class, 'pagePay']);
Route::get('/quote/{id}', [ProspectServiceController::class, 'quoteDoc']);
Route::get('/single-quote/{id}', [ClientServiceController::class, 'quoteDoc']);
Route::get('/receipts-doc/{id}', [ReceiptController::class, 'receiptDoc']);
Route::get('/inventories-history-doc/{id}', [InventoryController::class, 'historyDoc']);
Route::get('/inventory-fix/doc/{id}', [InventoryFixController::class, 'inventoryFixDoc']);
Route::get('/orders-doc/{id}', [OrderController::class, 'orderDoc']);

Route::get('/cache', function () {

    Artisan::call('view:clear');

    Artisan::call('route:clear');

    Artisan::call('cache:clear');

    Artisan::call('config:clear');

    Artisan::call('config:cache');

    return 'CACHE DEL SISTEMA CONFIGURADA CON EXITO';

});

Route::get('/artisan/{secret}', function ($secret) {

    if ($secret === 'secret') {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        Artisan::call('passport:install');
        Artisan::call('storage:link');

        return 'DB MIGRADA CON EXITO';
    }

   return 'No existe el secreto';

});


Route::get('{any}', function () {
    return view('app');
})->where('any','.*');

