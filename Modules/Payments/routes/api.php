<?php

use Illuminate\Support\Facades\Route;
use Modules\Payments\Http\Controllers\WebhookController;

Route::post('/webhooks/{gateway}', WebhookController::class)->name('payments.webhook');
