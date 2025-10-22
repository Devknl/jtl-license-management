<?php

use App\Http\Controllers\LicenseController;
use Illuminate\Support\Facades\Route;

// Startseite mit Landingpage
Route::get('/', function () {
    return view('welcome');
});

// Lizenz-Routes
Route::resource('licenses', LicenseController::class);

// Validierungs-Routes
Route::get('/validate-license', [LicenseController::class, 'showValidationForm'])->name('validate.form');
Route::post('/validate-license', [LicenseController::class, 'validateLicense'])->name('validate.license');