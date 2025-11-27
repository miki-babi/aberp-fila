<?php

namespace App\Filament\Resources\Specs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SpecForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->nullable(),

                Select::make('sub_category_id')
                    ->relationship('subCategory', 'name')
                    ->nullable(),
                
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
