<?php

namespace App\Filament\Resources\Alternatives\Schemas;

use App\Models\Alternative;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class AlternativeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Grid::make(1)
          ->Schema([
            TextInput::make('name')
              ->label('Kode Alternatif')
              ->required()
              ->maxLength(5)
              ->prefix('A')
              ->default(function () {
                $last = Alternative::orderBy('name', 'desc')->first();
                if (!$last) return '01';
                return '0' . (int) preg_replace('/[^0-9]/', '', $last->name) + 1;
              }),

            Textarea::make('description')
              ->label('Nama Alternatif')
              ->required()
              ->rows(3)
              ->maxLength(255),
          ])
      ])
      ->columns(3);
  }
}
