<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('report_date')
                    ->label('Report Date')
                    ->required(),
                TextInput::make('file_path')
                    ->label('File Path')
                    ->required(),
            ]);
    }
}
