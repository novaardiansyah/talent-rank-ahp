<?php

namespace App\Filament\Resources\CriterionComparisons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CriterionComparisonsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        // 
      ])
      ->filters([
        TrashedFilter::make(),
      ])
      ->recordActions([
        // 
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          //
        ]),
      ]);
  }
}
