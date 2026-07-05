<?php

namespace Modules\Crm\Filament\Resources\PipelineStageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Crm\Filament\Resources\PipelineStageResource;

class EditPipelineStage extends EditRecord
{
    protected static string $resource = PipelineStageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
