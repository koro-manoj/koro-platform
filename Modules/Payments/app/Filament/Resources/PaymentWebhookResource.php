<?php

namespace Modules\Payments\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Payments\Filament\Resources\PaymentWebhookResource\Pages;
use Modules\Payments\Models\PaymentWebhook;

class PaymentWebhookResource extends Resource
{
    protected static ?string $model = PaymentWebhook::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    protected static ?string $navigationGroup = 'Billing';

    protected static ?string $navigationLabel = 'Webhooks';

    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('gateway')->disabled(),
            Forms\Components\TextInput::make('event_id')->disabled(),
            Forms\Components\TextInput::make('event_type')->disabled(),
            Forms\Components\TextInput::make('status')->disabled(),
            Forms\Components\DateTimePicker::make('processed_at')->disabled(),
            Forms\Components\Textarea::make('payload')
                ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
                ->rows(16)
                ->columnSpanFull()
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gateway')->badge(),
                Tables\Columns\TextColumn::make('event_type')->searchable(),
                Tables\Columns\TextColumn::make('event_id')->limit(24)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('processed_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentWebhooks::route('/'),
            'view' => Pages\ViewPaymentWebhook::route('/{record}'),
        ];
    }
}
