<?php

namespace App\Filament\Resources\Alternatives\Tables;

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
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AlternativesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('index')
          ->label('#')
          ->rowIndex(),
        TextColumn::make('name')
          ->label('Kode Alternatif')
          ->searchable()
          ->sortable()
          ->searchable(),
        TextColumn::make('description')
          ->label('Nama Alternatif')
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
            ->modalHeading('Lihat detail Alternatif'),

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
}
