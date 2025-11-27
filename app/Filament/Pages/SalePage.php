<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Category;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class SalePage extends Page
{
    protected string $view = 'filament.pages.sale-page';

    // public function mount()
    // {
    //     //
    //     $categories = Category::all();
    //     $this->viewData['categories'] = $categories;

    // }
    protected function getViewData(): array
    {
        return [
            'categories' => Category::all(),
        ];
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;



}
