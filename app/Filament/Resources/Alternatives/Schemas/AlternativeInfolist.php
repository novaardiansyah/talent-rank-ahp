<?php

namespace App\Filament\Resources\Alternatives\Schemas;

use App\Models\Alternative;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlternativeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make()
          ->Schema([
            TextEntry::make('name')
              ->label('Kode Alternatif'),
            TextEntry::make('description')
              ->label('Nama Alternatif')
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
}
