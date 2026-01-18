<?php

/*
 * Project Name: talent-rank-ahp
 * File: UsersTable.php
 * Created Date: Sunday January 18th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\Users\Tables;

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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('index')
          ->label('#')
          ->rowIndex(),
        ImageColumn::make('avatar_url')
          ->label('Avatar')
          ->circular()
          ->toggleable(),
        TextColumn::make('name')
          ->label('Nama Lengkap')
          ->searchable()
          ->toggleable(),
        TextColumn::make('email')
          ->label('Alamat Email')
          ->searchable()
          ->toggleable(),
        TextColumn::make('email_verified_at')
          ->label('Verifikasi')
          ->dateTime('d M Y, H.i')
          ->sortable()
          ->sinceTooltip()
          ->toggleable(),
        IconColumn::make('has_email_authentication')
          ->label('Email OTP')
          ->boolean()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('created_at')
          ->dateTime('d M Y, H.i')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true)
          ->sinceTooltip(),
        TextColumn::make('updated_at')
          ->dateTime('d M Y, H.i')
          ->sortable()
          ->toggleable()
          ->sinceTooltip(),
        TextColumn::make('deleted_at')
          ->dateTime('d M Y, H.i')
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true)
          ->sinceTooltip(),
      ])
      ->filters([
        TrashedFilter::make()
          ->native(false),
      ])
      ->recordActions([
        ActionGroup::make([
          ViewAction::make(),
          EditAction::make(),
          DeleteAction::make(),
          RestoreAction::make(),
          ForceDeleteAction::make(),
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
