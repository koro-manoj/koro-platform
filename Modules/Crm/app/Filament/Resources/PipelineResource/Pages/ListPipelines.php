<?php

namespace Modules\Crm\Filament\Resources\PipelineResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Crm\Filament\Resources\PipelineResource;

class ListPipelines extends ListRecords
{
    protected static string $resource = PipelineResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
