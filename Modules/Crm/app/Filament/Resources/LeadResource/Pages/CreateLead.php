<?php

namespace Modules\Crm\Filament\Resources\LeadResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Crm\Filament\Resources\LeadResource;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;
}
