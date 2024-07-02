<?php

use Domains\Company\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('companies')->group(function () {
    Route::post('/', [CompanyController::class, 'create']);
    Route::get('/', [CompanyController::class, 'search']);
    Route::get('/{id}', [CompanyController::class, 'get']);
    Route::put('/{id}', [CompanyController::class, 'update']);
})->middleware('auth:sanctum');
