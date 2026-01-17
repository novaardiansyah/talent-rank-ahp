<?php

namespace App\Filament\Resources\Criterias;

use BackedEnum;
use UnitEnum;
use App\Filament\Resources\Criterias\Pages\ManageCriterias;
use App\Filament\Resources\Criterias\Pages\CreateCriteria;
use App\Filament\Resources\Criterias\Pages\EditCriteria;
use App\Models\Criteria;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CriteriaResource extends Resource
{
  protected static ?string $model = Criteria::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNumberedList;

  protected static string|UnitEnum|null $navigationGroup = 'Kriteria';

  protected static ?int $navigationSort = 10;

  protected static ?string $recordTitleAttribute = 'description';

  protected static ?string $pluralModelLabel = 'Kriteria';

  protected static ?string $modelLabel = 'Kriteria';

  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Grid::make(1)
          ->Schema([
            TextInput::make('name')
              ->label('Kode Kriteria')
              ->required()
              ->maxLength(5)
              ->prefix('C')
              ->default(function () {
                $last = Criteria::orderBy('name', 'desc')->first();
                if (!$last) return '01';
                return '0' . (int) preg_replace('/[^0-9]/', '', $last->name) + 1;
              }),

            Textarea::make('description')
              ->label('Nama Kriteria')
              ->required()
              ->rows(3)
              ->maxLength(255),
          ])
      ])
      ->columns(3);
  }

  public static function infolist(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make()
          ->Schema([
            TextEntry::make('name')
              ->label('Kode Kriteria'),
            TextEntry::make('description')
              ->label('Nama Kriteria')
              ->columnSpan(2),
          ])
          ->columns(3),

        Section::make()
          ->Schema([
            TextEntry::make('created_at')
              ->label('Dibuat pada')
              ->dateTime('d M Y, H.i')
              ->sinceTooltip(),
            TextEntry::make('updated_at')
              ->label('Diperbarui pada')
              ->dateTime('d M Y, H.i')
              ->sinceTooltip(),
            TextEntry::make('deleted_at')
              ->label('Dihapus pada')
              ->dateTime('d M Y, H.i')
              ->sinceTooltip(),
          ])
          ->columns(3),
      ])
      ->columns(1);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('name')
      ->columns([
        TextColumn::make('index')
          ->label('#')
          ->rowIndex(),
        TextColumn::make('name')
          ->label('Kode Kriteria')
          ->searchable()
          ->sortable()
          ->searchable(),
        TextColumn::make('description')
          ->label('Nama Kriteria')
          ->searchable()
          ->toggleable(),
        TextColumn::make('created_at')
          ->label('Dibuat pada')
          ->dateTime('d M Y, H.i')
          ->sinceTooltip()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')
          ->label('Diperbarui pada')
          ->dateTime('d M Y, H.i')
          ->sinceTooltip()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: false),
        TextColumn::make('deleted_at')
          ->label('Dihapus pada')
          ->dateTime('d M Y, H.i')
          ->sinceTooltip()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        TrashedFilter::make()
          ->native(false),
      ])
      ->defaultSort('name', 'asc')
      ->recordAction('view')
      ->recordUrl(null)
      ->recordActions([
        ActionGroup::make([
          ViewAction::make()
            ->slideOver()
            ->modalWidth(Width::TwoExtraLarge)
            ->modalHeading('Lihat detail kriteria'),

          EditAction::make(),
          DeleteAction::make(),
          ForceDeleteAction::make(),
          RestoreAction::make(),
        ])
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
          ForceDeleteBulkAction::make(),
          RestoreBulkAction::make(),
        ]),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => ManageCriterias::route('/'),
      'create' => CreateCriteria::route('/create'),
      'edit' => EditCriteria::route('/{record}/edit'),
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
