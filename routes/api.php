<?php

use App\Http\Controllers\OrdersController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); 


Route::post('create-order',[OrdersController::class,'CreateOrder']);
Route::get('client-resume-order',[OrdersController::class,'GetOrderByClient']);
Route::post('create-payment-order',[OrdersController::class,'CreatePaymentOrder']);
Route::get('resume-status-order/{id}',[OrdersController::class,'GetResumeOrderStatus']);
Route::get('list-order-store',[OrdersController::class,'GetListOrderStore']);
Route::post('info-transaction',[OrdersController::class,'InfoTransaction']);
