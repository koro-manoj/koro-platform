<?php

namespace Modules\Erp\Filament\Resources\OrderResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Erp\Filament\Resources\OrderResource;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
