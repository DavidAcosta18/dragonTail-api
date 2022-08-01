<?php
use App\Http\Controllers\ordenController;


Route::post('', [ordenController::class, 'create']);
Route::put('/{orderId}', [ordenController::class, 'assign']);
Route::get('/{orderId}', [ordenController::class, 'status']);
