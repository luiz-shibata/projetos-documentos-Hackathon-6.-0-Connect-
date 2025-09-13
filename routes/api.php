<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioWebhookController;

Route::any('/twilio/webhook', [TwilioWebhookController::class, 'handle']);
