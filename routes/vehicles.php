<?php
use App\Http\Controllers\VehicleController;


Route::post('', [VehicleController::class, 'createVehicle']);
