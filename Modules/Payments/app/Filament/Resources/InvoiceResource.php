<?php

namespace Modules\Payments\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Payments\Filament\Resources\InvoiceResource\Pages;
use Modules\Payments\Models\Invoice;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Billing';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('number')->required(),
            Forms\Components\TextInput::make('customer_email')->email()->required(),
            Forms\Components\TextInput::make('customer_name'),
            Forms\Components\TextInput::make('amount_cents')->numeric()->required(),
            Forms\Components\TextInput::make('currency')->default('USD')->maxLength(3),
            Forms\Components\Select::make('status')->options([
                'draft' => 'Draft',
                'pending' => 'Pending',
                'paid' => 'Paid',
                'failed' => 'Failed',
            ])->required(),
            Forms\Components\TextInput::make('gateway'),
            Forms\Components\TextInput::make('gateway_reference'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')->searchable(),
                Tables\Columns\TextColumn::make('customer_email'),
                Tables\Columns\TextColumn::make('amount_cents')->money(fn ($record) => $record->currency, divideBy: 100),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('paid_at')->dateTime(),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
