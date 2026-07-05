<?php

namespace Modules\Crm\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Crm\Filament\Resources\PipelineResource\Pages;
use Modules\Crm\Models\Pipeline;

class PipelineResource extends Resource
{
    protected static ?string $model = Pipeline::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(120),
            Forms\Components\Toggle::make('is_default')->label('Default pipeline'),
            Forms\Components\Repeater::make('stages')
                ->relationship('stages')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->maxLength(80),
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                ])
                ->orderColumn('sort_order')
                ->collapsible()
                ->defaultItems(1)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\IconColumn::make('is_default')->boolean()->label('Default'),
                Tables\Columns\TextColumn::make('stages_count')->counts('stages')->label('Stages'),
                Tables\Columns\TextColumn::make('leads_count')->counts('leads')->label('Leads'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPipelines::route('/'),
            'create' => Pages\CreatePipeline::route('/create'),
            'edit' => Pages\EditPipeline::route('/{record}/edit'),
        ];
    }
}
