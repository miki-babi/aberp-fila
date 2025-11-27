<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->label('Product Name'),
                TextColumn::make('category.name')->label('Category'),
                TextColumn::make('subCategory.name')->label('Sub Category'),
                TextColumn::make('spec.name')->label('Specs'),
                ImageColumn::make('image')
                    ->label('Product Image')
                    ->disk('public')   // matches the disk used in FileUpload
                    ->square()         // optional: makes thumbnail square
                    ->imageHeight(80),          // optional: control displayed size
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
