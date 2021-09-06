<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\ProspectServiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryFixController;
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

Route::get('/test', function () {

    $products =  Product::with(['prices', 'providers', 'relates'])
        ->filter($this->params['name'] ?? null)
        ->type($this->params['type'] ?? null)
        ->get();

    return  $products->map(function ($product) {
        $salePrice = $product->price->sale_price ?? $product->prices[0]->sale_price;
        $price = $product->price->price ?? $product->prices[0]->price;
        return [
            'code' => $product->code,
            'name' => $product->name,
            'description' => $product->description,
            'type' => $product->gettype(),
            'measure' => $product->measure->name,
            'price' =>  number_format($price, 2, '.', ','),
            'sale_price' =>  number_format($salePrice, 2, '.', ',')
        ];
    });

});

Route::get('/page-pay', [ClientServiceController::class, 'pagePay']);
Route::get('/quote/{id}', [ProspectServiceController::class, 'quoteDoc']);
Route::get('/single-quote/{id}', [ClientServiceController::class, 'quoteDoc']);
Route::get('/receipts-doc/{id}', [ReceiptController::class, 'receiptDoc']);
Route::get('/inventories-history-doc/{id}', [InventoryController::class, 'historyDoc']);
Route::get('/inventory-fix/doc/{id}', [InventoryFixController::class, 'inventoryFixDoc']);

Route::get('/cache', function () {

    Artisan::call('view:clear');

    Artisan::call('route:clear');

    Artisan::call('cache:clear');

    Artisan::call('config:clear');

    Artisan::call('config:cache');

    return 'CACHE DEL SISTEMA LIMPIADA CON EXITO';

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

