<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                // Select::make('role')
                //     ->options(
                //         [
                //             'user' => 'user',
                //             'admin' => 'admin',
                //         ]
                //     )
                // ->required(),
                Select::make('roles')
    ->relationship('roles', 'name')
    ->multiple()
    ->preload()
    ->searchable(),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->label('Password')
                    ->hint('Leave blank to keep current password'),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),

            ]);
    }
}
