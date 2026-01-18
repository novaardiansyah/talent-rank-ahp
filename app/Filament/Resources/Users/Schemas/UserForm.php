<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
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
          ->native(false),
        TextInput::make('password')
          ->password()
          ->required(fn (string $operation): bool => $operation === 'create')
          ->revealable(),
      ]);
  }
}
