<?php

namespace Modules\Crm\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Crm\Filament\Resources\LeadResource\Pages;
use Modules\Crm\Models\Lead;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-funnel';

    protected static ?string $navigationGroup = 'CRM';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('contact_id')->relationship('contact', 'first_name')->required(),
            Forms\Components\Select::make('pipeline_id')->relationship('pipeline', 'name')->required(),
            Forms\Components\Select::make('pipeline_stage_id')->relationship('stage', 'name')->required(),
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('value_cents')->numeric()->default(0),
            Forms\Components\Select::make('status')->options([
                'open' => 'Open',
                'won' => 'Won',
                'lost' => 'Lost',
            ])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('contact.first_name'),
                Tables\Columns\TextColumn::make('stage.name'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
