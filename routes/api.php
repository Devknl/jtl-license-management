<?php

use App\Http\Controllers\LicenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/validate', [LicenseController::class, 'apiValidateLicense']);