<?php

use App\Http\Controllers\LicenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/licenses', [LicenseController::class, 'index']);
Route::post('/licenses', [LicenseController::class, 'store']);
Route::get('/licenses/{id}', [LicenseController::class, 'show']);
Route::put('/licenses/{id}', [LicenseController::class, 'update']);
Route::delete('/licenses/{id}', [LicenseController::class, 'destroy']);
Route::post('/validate', [LicenseController::class, 'apiValidateLicense']);