<?php

namespace App\Filament\Resources\AlternativeComparisons;

use BackedEnum;
use UnitEnum;
use App\Filament\Resources\AlternativeComparisons\Pages\CreateAlternativeComparison;
use App\Filament\Resources\AlternativeComparisons\Pages\EditAlternativeComparison;
use App\Filament\Resources\AlternativeComparisons\Pages\ListAlternativeComparisons;
use App\Filament\Resources\AlternativeComparisons\Pages\ViewAlternativeComparison;
use App\Filament\Resources\AlternativeComparisons\Schemas\AlternativeComparisonForm;
use App\Filament\Resources\AlternativeComparisons\Schemas\AlternativeComparisonInfolist;
use App\Filament\Resources\AlternativeComparisons\Tables\AlternativeComparisonsTable;
use App\Models\AlternativeComparison;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlternativeComparisonResource extends Resource
{
  protected static ?string $model = AlternativeComparison::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

  protected static string|UnitEnum|null $navigationGroup = 'Alternatif';

  protected static ?int $navigationSort = 20;

  protected static ?string $recordTitleAttribute = 'description';

  protected static ?string $pluralModelLabel = 'Bobot Alternatif';

  protected static ?string $modelLabel = 'Bobot Alternatif';

  public static function form(Schema $schema): Schema
  {
    return AlternativeComparisonForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return AlternativeComparisonInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return AlternativeComparisonsTable::configure($table);
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
      'index' => ListAlternativeComparisons::route('/'),
      'create' => CreateAlternativeComparison::route('/create'),
      'view' => ViewAlternativeComparison::route('/{record}'),
      'edit' => EditAlternativeComparison::route('/{record}/edit'),
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
