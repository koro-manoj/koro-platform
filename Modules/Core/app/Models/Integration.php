<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'credentials',
        'metadata',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => 'encrypted:array',
            'metadata' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
