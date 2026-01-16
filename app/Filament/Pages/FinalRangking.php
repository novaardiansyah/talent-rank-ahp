<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class FinalRangking extends Page
{
  protected string $view = 'filament.pages.final-rangking';
  protected static ?string $navigationLabel = 'Perhitungan';
  protected static ?string $title = 'Perhitungan';
  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;
  protected static string|UnitEnum|null $navigationGroup = 'Perhitungan Final';
  protected static ?string $slug = 'report/final-rangking';

  public function getBreadcrumbs(): array
  {
    return [
      '/report/final-rangking' => 'Perhitungan Final',
      '#' => 'Perhitungan',
    ];
  }
}
