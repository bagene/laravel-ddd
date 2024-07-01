<?php

use Domains\Company\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('companies')->group(function () {
    Route::post('/', [CompanyController::class, 'create']);
})->middleware('auth:sanctum');
