<?php

namespace App\Filament\Resources\Telegrams\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TelegramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('bot_token')
                    ->label('Bot Token')
                    ->required(),
                TextInput::make('user_id')
                    ->label('Telegram User ID')
                    ->required(),
                // Select::make('report_frequency')
                //     ->label('Report Frequency')
                //     ->options([
                //         'daily' => 'Daily',
                //         'weekly' => 'Weekly',
                //         'monthly' => 'Monthly',
                //     ])
                //     ->default('daily')
                //     ->required(),
                // Select::make('report_every_sale')
                //     ->label('Report Every Sale')
                //     ->options([
                //         1 => 'Yes',
                //         0 => 'No',
                //     ])
                //     ->default(1)
                //     ->required(),
            ]);
    }
}
