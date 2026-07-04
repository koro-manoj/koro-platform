<?php

use Illuminate\Support\Facades\Route;
use Modules\Erp\Http\Controllers\ErpController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('erps', ErpController::class)->names('erp');
});
