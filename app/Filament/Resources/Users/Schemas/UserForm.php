<?php

/*
 * Project Name: talent-rank-ahp
 * File: UserForm.php
 * Created Date: Sunday January 18th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->label('Nama Lengkap')
          ->required(),
        TextInput::make('email')
          ->label('Alamat Email')
          ->email()
          ->required(),
        DateTimePicker::make('email_verified_at')
          ->label('Verifikasi')
          ->displayFormat('d M Y, H.i')
          ->native(false)
          ->default(now()),
        TextInput::make('password')
          ->password()
          ->required(fn (string $operation): bool => $operation === 'create')
          ->revealable(),
        Select::make('roles')
          ->label('Hak Akses')
          ->relationship('roles', 'name')
          ->preload()
          ->searchable()
          ->required(),
      ]);
  }
}
