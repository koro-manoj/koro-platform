<?php

namespace Modules\Api\Http\Controllers\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Cms\Models\Page;
use Modules\Crm\Models\Contact;
use Modules\Erp\Models\InventoryItem;
use Modules\Payments\Models\Invoice;

class ResourceController extends Controller
{
    public function invoices(): JsonResponse
    {
        return response()->json(Invoice::query()->latest()->paginate(20));
    }

    public function contacts(): JsonResponse
    {
        return response()->json(Contact::query()->latest()->paginate(20));
    }

    public function pages(): JsonResponse
    {
        return response()->json(Page::query()->where('status', 'published')->paginate(20));
    }

    public function inventory(): JsonResponse
    {
        return response()->json(InventoryItem::query()->paginate(20));
    }
}
