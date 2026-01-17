<?php

/*
 * Project Name: talent-rank-ahp
 * File: AlternativeResource.php
 * Created Date: Thursday January 8th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\Alternatives;

use App\Filament\Resources\Alternatives\Pages\CreateAlternative;
use App\Filament\Resources\Alternatives\Pages\EditAlternative;
use App\Filament\Resources\Alternatives\Pages\ListAlternatives;
use App\Filament\Resources\Alternatives\Pages\ViewAlternative;
use App\Filament\Resources\Alternatives\Schemas\AlternativeForm;
use App\Filament\Resources\Alternatives\Schemas\AlternativeInfolist;
use App\Filament\Resources\Alternatives\Tables\AlternativesTable;
use App\Models\Alternative;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AlternativeResource extends Resource
{
  protected static ?string $model = Alternative::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNumberedList;

  protected static string|UnitEnum|null $navigationGroup = 'Alternatif';

  protected static ?int $navigationSort = 10;
  
  protected static ?string $recordTitleAttribute = 'description';

  protected static ?string $pluralModelLabel = 'Alternatif';

  protected static ?string $modelLabel = 'Alternatif';

  public static function form(Schema $schema): Schema
  {
    return AlternativeForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return AlternativeInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return AlternativesTable::configure($table);
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
      'index' => ListAlternatives::route('/'),
      'create' => CreateAlternative::route('/create'),
      'view' => ViewAlternative::route('/{record}'),
      'edit' => EditAlternative::route('/{record}/edit'),
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
