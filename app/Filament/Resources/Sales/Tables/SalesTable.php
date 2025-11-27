<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use App\Models\Report;
use App\Models\Telegram;
use App\Services\TelegramService;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Salesperson')->toggleable(),
                TextColumn::make('product.name')->label('Product')->toggleable(),
                TextColumn::make('quantity')->label('Quantity')->toggleable(),
                TextColumn::make('bank_transfer')->label('Bank Transfer')->toggleable(),
                TextColumn::make('cash_transfer')->label('Cash Transfer')->toggleable(),
                TextColumn::make('total_price')->label('Total Price')->toggleable(),
                TextColumn::make('sale_date')->label('Sale Date')->toggleable(),
            ])
            ->filters([
                Filter::make('sale_date')
                    ->label('Sale Date')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('sale_date', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('sale_date', '<=', $data['until']));
                    }),

                SelectFilter::make('user')
                    ->label('Salesperson')
                    ->relationship('user', 'name'),

                SelectFilter::make('product')
                    ->label('Product')
                    ->relationship('product', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('create_report')
                        ->label('Create Report')
                        ->icon('heroicon-o-document-text')
                        ->action(function (Collection $records) {
                            $pdf = Pdf::loadView('reports.sales_report', ['sales' => $records]);
                            $fileName = 'sales_report_' . now()->format('Y_m_d_H_i_s') . '.pdf';
                            $filePath = 'reports/' . $fileName;

                            Storage::disk('public')->put($filePath, $pdf->output());

                            Report::create([
                                'report_date' => now(),
                                'file_path' => $filePath,
                            ]);

                            // Show success notification for report creation
                            Notification::make()
                                ->title('Report created successfully')
                                ->success()
                                ->send();

                            // Send PDF to Telegram
                            $telegram = Telegram::first();
                            if ($telegram) {
                                $fullPath = Storage::disk('public')->path($filePath);
                                $sent = TelegramService::sendDocument(
                                    $telegram->bot_token,
                                    $telegram->user_id,
                                    $fullPath,
                                    'Sales Report - ' . now()->format('Y-m-d H:i')
                                );

                                if ($sent) {
                                    Notification::make()
                                        ->title('PDF sent to Telegram successfully')
                                        ->success()
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title('Failed to send PDF to Telegram')
                                        ->warning()
                                        ->send();
                                }
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
