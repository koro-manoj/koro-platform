<?php

namespace Modules\Erp\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Erp\Filament\Resources\InventoryItemResource\Pages;
use Modules\Erp\Models\InventoryItem;

class InventoryItemResource extends Resource
{
    protected static ?string $model = InventoryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Operations';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('sku')->required(),
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('quantity_on_hand')->numeric()->default(0),
            Forms\Components\TextInput::make('reorder_level')->numeric()->default(0),
            Forms\Components\TextInput::make('location'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('quantity_on_hand'),
                Tables\Columns\TextColumn::make('location'),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryItems::route('/'),
            'create' => Pages\CreateInventoryItem::route('/create'),
            'edit' => Pages\EditInventoryItem::route('/{record}/edit'),
        ];
    }
}
