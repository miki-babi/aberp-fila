<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class SalesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            Select::make('user_id')
            ->relationship('user', 'name') // User model must have 'name'
            ->required()
            ->label('Salesperson'),

        Select::make('product_id')
            ->relationship('product', 'name') // Product model must have 'name'
            ->required()
            ->label('Product'),

        TextInput::make('quantity')
            ->numeric()
            ->minValue(1)
            ->default(1)
            ->required()
            ->label('Quantity'),

        TextInput::make('bank_transfer')
            ->numeric()
            ->step(0.01)
            ->label('Bank Transfer')
            ->reactive()
            ->afterStateUpdated(fn ($state, callable $set, $get) => $set('total_price', ($state ?? 0) + ($get('cash_transfer') ?? 0)))
            ->nullable(),

        TextInput::make('cash_transfer')
            ->numeric()
            ->step(0.01)
            ->label('Cash Transfer')
            ->reactive()
            ->afterStateUpdated(fn ($state, callable $set, $get) => $set('total_price', ($state ?? 0) + ($get('bank_transfer') ?? 0)))
            ->nullable(),

        TextInput::make('total_price')
            ->numeric()
            ->step(0.01)
            ->label('Total Price')
            ->readOnly()
            ->default(0),

        DateTimePicker::make('sale_date')
            ->label('Sale Date')
            ->default(now())
            ->required(),
            ]);
    }
}
