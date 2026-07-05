<?php

namespace Modules\Payments\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Payments\Filament\Resources\PaymentResource\Pages;
use Modules\Payments\Models\Payment;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Billing';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('invoice_id')
                ->relationship('invoice', 'number')
                ->disabled(),
            Forms\Components\TextInput::make('provider')->disabled(),
            Forms\Components\TextInput::make('status')->disabled(),
            Forms\Components\TextInput::make('stripe_checkout_session_id')->disabled(),
            Forms\Components\TextInput::make('amount_cents')->disabled(),
            Forms\Components\TextInput::make('currency')->disabled(),
            Forms\Components\DateTimePicker::make('paid_at')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice.number')->label('Invoice')->searchable(),
                Tables\Columns\TextColumn::make('provider')->badge(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('amount_cents')->money(fn ($record) => $record->currency, divideBy: 100),
                Tables\Columns\TextColumn::make('stripe_checkout_session_id')->label('Session')->limit(20)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('paid_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'view' => Pages\ViewPayment::route('/{record}'),
        ];
    }
}
