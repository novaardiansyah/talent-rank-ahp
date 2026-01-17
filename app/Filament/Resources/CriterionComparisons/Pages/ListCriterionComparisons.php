<?php

/*
 * Project Name: talent-rank-ahp
 * File: ListCriterionComparisons.php
 * Created Date: Wednesday January 7th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

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
