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

use App\Events\WebsocketEvent;
use App\Http\Controllers\ConsumeGraphqlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/app', function () {
    return view('app');
});
Route::get('/consultaDispositivo', [ConsumeGraphqlController::class, 'consultaDispositivo']);
Route::get('/consultaMarca', [ConsumeGraphqlController::class, 'consultaMarca']);
Route::get('/consultaGeral', [ConsumeGraphqlController::class, 'consultaGeral']);
