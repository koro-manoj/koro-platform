<?php

namespace Modules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'erp_orders';

    protected $fillable = ['order_number', 'invoice_id', 'status', 'line_items', 'total_cents'];

    protected function casts(): array
    {
        return ['line_items' => 'array'];
    }
}
