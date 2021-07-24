<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\ProspectServiceController;
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

