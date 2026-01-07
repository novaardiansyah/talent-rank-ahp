<?php

namespace App\Filament\Resources\CriterionComparisons\Pages;

use App\Filament\Resources\CriterionComparisons\CriterionComparisonResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListCriterionComparisons extends ListRecords
{
  protected static string $resource = CriterionComparisonResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Action::make('matrix-comparison')
        ->label('Matrix Perbandingan')
        ->icon('heroicon-o-table-cells')
        ->url(fn() => CriterionComparisonResource::getUrl('matrix-comparison')),
    ];
  }
}
