<?php

use Illuminate\Support\Facades\Route;
use Modules\Erp\Http\Controllers\ErpController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('erps', ErpController::class)->names('erp');
});
