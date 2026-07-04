<?php

namespace Modules\Api\Http\Controllers\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cms\Models\Page;
use Modules\Crm\Models\Contact;
use Modules\Ecommerce\Models\Product;
use Modules\Erp\Models\InventoryItem;
use Modules\Payments\Models\Invoice;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::query()->where('is_active', true)->paginate(20));
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }
}
