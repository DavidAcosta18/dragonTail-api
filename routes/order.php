<?php
use App\Http\Controllers\ordenController;


Route::post('', [ordenController::class, 'create']);
Route::put('/{orderId}/{storeNo}', [ordenController::class, 'changeStatus']);
Route::get('/{orderId}/{storeNo}', [ordenController::class, 'getOrder']);
