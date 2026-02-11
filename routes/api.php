<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/provinces', [LocationController::class, 'provinces'])->name('api.provinces');
Route::get('/cities/{provinceId}', [LocationController::class, 'cities'])->name('api.cities');
Route::get('/districts/{cityId}', [LocationController::class, 'districts'])->name('api.districts');
Route::get('/villages/{districtId}', [LocationController::class, 'villages'])->name('api.villages');
