<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\Pages\CreateSales;
use App\Filament\Resources\Sales\Pages\EditSales;
use App\Filament\Resources\Sales\Pages\ListSales;
use App\Filament\Resources\Sales\Schemas\SalesForm;
use App\Filament\Resources\Sales\Tables\SalesTable;
use App\Models\Sales;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SalesResource extends Resource
{
    protected static ?string $model = Sales::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'sales';

    public static function form(Schema $schema): Schema
    {
        return SalesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSales::route('/'),
            'create' => CreateSales::route('/create'),
            'edit' => EditSales::route('/{record}/edit'),
        ];
    }
    //     public static function canAccess(): bool
    // {
    //     return in_array(auth()->user()->role, ['admin', 'user']);
    // }

    public static function getEloquentQuery() : \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (Auth::user()->hasRole('sales')) {
            return $query->where('user_id', Auth::id());
        }
        return $query;
    }
}
