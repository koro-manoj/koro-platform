<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = ['filename', 'disk', 'path', 'mime_type', 'size', 'meta'];

    protected function casts(): array
    {
        return ['meta' => 'array'];
    }
}
