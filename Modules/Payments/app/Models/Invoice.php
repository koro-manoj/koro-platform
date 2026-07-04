<?php

namespace Modules\Payments\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'number',
        'user_id',
        'customer_email',
        'customer_name',
        'amount_cents',
        'currency',
        'status',
        'gateway',
        'gateway_reference',
        'line_items',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'line_items' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function amount(): float
    {
        return $this->amount_cents / 100;
    }
}
