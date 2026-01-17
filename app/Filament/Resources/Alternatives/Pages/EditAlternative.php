<?php

/*
 * Project Name: talent-rank-ahp
 * File: EditAlternative.php
 * Created Date: Thursday January 8th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\Alternatives\Pages;

use App\Filament\Resources\Alternatives\AlternativeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAlternative extends EditRecord
{
  protected static string $resource = AlternativeResource::class;

  protected function mutateFormDataBeforeFill(array $data): array
  {
    $data['name'] = (int) preg_replace('/[^0-9]/', '', $data['name']);
    return $data;
  }

  protected function getHeaderActions(): array
  {
    return [
      ViewAction::make(),
      DeleteAction::make(),
      ForceDeleteAction::make(),
      RestoreAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    $resource = static::getResource();
    return $resource::getUrl('index');
  }
}
