<?php

/*
 * Project Name: talent-rank-ahp
 * File: AlternativeForm.php
 * Created Date: Thursday January 8th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

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
