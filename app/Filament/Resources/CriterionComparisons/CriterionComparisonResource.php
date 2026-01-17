<?php

/*
 * Project Name: talent-rank-ahp
 * File: CriterionComparisonResource.php
 * Created Date: Wednesday January 7th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\CriterionComparisons;

use BackedEnum;
use App\Filament\Resources\CriterionComparisons\Pages\CreateCriterionComparison;
use App\Filament\Resources\CriterionComparisons\Pages\EditCriterionComparison;
use App\Filament\Resources\CriterionComparisons\Pages\ListCriterionComparisons;
use App\Filament\Resources\CriterionComparisons\Pages\MatrixComparison;
use App\Filament\Resources\CriterionComparisons\Pages\ViewCriterionComparison;
use App\Filament\Resources\CriterionComparisons\Schemas\CriterionComparisonForm;
use App\Filament\Resources\CriterionComparisons\Schemas\CriterionComparisonInfolist;
use App\Filament\Resources\CriterionComparisons\Tables\CriterionComparisonsTable;
use App\Models\CriterionComparison;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CriterionComparisonResource extends Resource
{
  protected static ?string $model = CriterionComparison::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

  protected static string|UnitEnum|null $navigationGroup = 'Kriteria';

  protected static ?int $navigationSort = 20;

  protected static ?string $recordTitleAttribute = 'description';

  protected static ?string $pluralModelLabel = 'Bobot Kriteria';

  protected static ?string $modelLabel = 'Bobot Kriteria';

  public static function form(Schema $schema): Schema
  {
    return CriterionComparisonForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return CriterionComparisonInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return CriterionComparisonsTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index'  => MatrixComparison::route('/matrix-comparison'),
      'create' => CreateCriterionComparison::route('/create'),
      'view'   => ViewCriterionComparison::route('/{record}'),
      'edit'   => EditCriterionComparison::route('/{record}/edit'),
    ];
  }

  public static function getRecordRouteBindingEloquentQuery(): Builder
  {
    return parent::getRecordRouteBindingEloquentQuery()
      ->withoutGlobalScopes([
        SoftDeletingScope::class,
      ]);
  }
}
