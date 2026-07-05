<?php

namespace Modules\Crm\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Crm\Filament\Resources\PipelineStageResource\Pages;
use Modules\Crm\Models\PipelineStage;

class PipelineStageResource extends Resource
{
    protected static ?string $model = PipelineStage::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?string $navigationLabel = 'Stages';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('pipeline_id')
                ->relationship('pipeline', 'name')
                ->required()
                ->searchable(),
            Forms\Components\TextInput::make('name')->required()->maxLength(80),
            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0)
                ->minValue(0)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pipeline.name')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('leads_count')->counts('leads')->label('Leads'),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPipelineStages::route('/'),
            'create' => Pages\CreatePipelineStage::route('/create'),
            'edit' => Pages\EditPipelineStage::route('/{record}/edit'),
        ];
    }
}
