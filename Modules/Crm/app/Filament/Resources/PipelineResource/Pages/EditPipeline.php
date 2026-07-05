<?php

namespace Modules\Crm\Filament\Resources\PipelineResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Crm\Filament\Resources\PipelineResource;

class EditPipeline extends EditRecord
{
    protected static string $resource = PipelineResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
