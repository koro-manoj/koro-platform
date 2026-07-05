<?php

namespace Modules\Erp\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Ecommerce\Models\Product;
use Modules\Erp\Models\InventoryItem;
use Modules\Erp\Models\Order;
use Modules\Payments\Models\Invoice;

class OrderFulfillmentService
{
    public function fulfill(Invoice $invoice): ?Order
    {
        if ($invoice->status !== 'paid') {
            return null;
        }

        $existing = Order::query()->where('invoice_id', $invoice->id)->first();

        if ($existing !== null) {
            return $existing;
        }

        return DB::transaction(function () use ($invoice): Order {
            $erpLineItems = [];

            foreach ($invoice->line_items ?? [] as $item) {
                $product = Product::query()->find($item['product_id'] ?? null);

                if ($product === null) {
                    continue;
                }

                $quantity = (int) ($item['quantity'] ?? 0);

                if ($quantity < 1) {
                    continue;
                }

                $erpLineItems[] = [
                    'sku' => $product->sku,
                    'name' => $item['name'] ?? $product->name,
                    'qty' => $quantity,
                ];

                if ($product->stock > 0) {
                    $product->decrement('stock', min($quantity, $product->stock));
                }

                InventoryItem::query()
                    ->where('sku', $product->sku)
                    ->first()
                    ?->decrement('quantity_on_hand', $quantity);
            }

            return Order::query()->create([
                'order_number' => 'ERP-'.Str::upper(Str::random(8)),
                'invoice_id' => $invoice->id,
                'status' => 'pending',
                'total_cents' => $invoice->amount_cents,
                'line_items' => $erpLineItems,
            ]);
        });
    }
}
