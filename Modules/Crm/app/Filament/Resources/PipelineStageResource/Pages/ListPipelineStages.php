<?php

namespace Modules\Crm\Filament\Resources\PipelineStageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Crm\Filament\Resources\PipelineStageResource;

class ListPipelineStages extends ListRecords
{
    protected static string $resource = PipelineStageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
