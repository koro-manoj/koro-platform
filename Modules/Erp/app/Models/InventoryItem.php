<?php

namespace Modules\Erp\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'quantity_on_hand',
        'reorder_level',
        'location',
    ];
}
