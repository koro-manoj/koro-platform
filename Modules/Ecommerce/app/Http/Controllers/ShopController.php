<?php

namespace Modules\Ecommerce\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ecommerce\Models\Cart;
use Modules\Ecommerce\Models\CartItem;
use Modules\Ecommerce\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::query()->where('is_active', true)->latest()->paginate(12);

        return view('ecommerce::shop.index', compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('ecommerce::shop.show', compact('product'));
    }
}
