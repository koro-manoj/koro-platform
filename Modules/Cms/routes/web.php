<?php

use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\PageController;

Route::get('/pages/{slug}', [PageController::class, 'show'])->name('cms.page');
