<?php

namespace Modules\Payments\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Payments\Services\PaymentGatewayManager;

class WebhookController extends Controller
{
    public function __invoke(Request $request, string $gateway, PaymentGatewayManager $manager): JsonResponse
    {
        $payload = $request->all();
        $eventId = (string) ($payload['id'] ?? $payload['event_id'] ?? uniqid('evt_'));
        $eventType = (string) ($payload['type'] ?? $payload['event_type'] ?? 'unknown');

        $manager->gateway($gateway)->verifyWebhook($payload, $request->header('Stripe-Signature'));
        $webhook = $manager->recordWebhook($gateway, $eventId, $eventType, $payload);

        return response()->json(['received' => true, 'id' => $webhook->id]);
    }
}
