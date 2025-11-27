<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Components\ImageUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name')
                    ->required()
                    ->label('Product Name'),

                FileUpload::make('image')
                    ->image()           // only allow images
                    ->disk('public')    // storage disk
                    ->directory('products') // folder in storage/app/public
                    ->nullable()
                    ->label('Product Image'),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->nullable()
                    ->label('Category'),

                Select::make('sub_category_id')
                    ->relationship('subCategory', 'name')
                    ->nullable()
                    ->label('Sub Category'),

                Select::make('spec_id')
                    ->relationship('spec', 'name')
                    ->nullable()
                    ->label('Specification'),
            ]);
    }
}
