<?php

/*
 * Project Name: talent-rank-ahp
 * File: CriterionComparisonsTable.php
 * Created Date: Wednesday January 7th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

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
