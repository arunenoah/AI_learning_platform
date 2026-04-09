<?php

use App\Http\Controllers\Api\IngestLinkController;
use App\Http\Controllers\Api\ResourceApiController;
use App\Http\Controllers\Api\WhatsAppWebhookController;
use Illuminate\Support\Facades\Route;

// WhatsApp agent link ingestion
Route::post('/ingest-link', [IngestLinkController::class, 'handle']);

Route::get('/resources', [ResourceApiController::class, 'index']);
Route::get('/resources/{resource}', [ResourceApiController::class, 'show']);

// WhatsApp Webhook (no auth — verified by token/signature)
Route::get('/whatsapp/webhook', [WhatsAppWebhookController::class, 'verify']);
Route::post('/whatsapp/webhook', [WhatsAppWebhookController::class, 'handle']);
