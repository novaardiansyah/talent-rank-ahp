<?php

/*
 * Project Name: talent-rank-ahp
 * File: EditCriteria.php
 * Created Date: Wednesday January 7th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\Criterias\Pages;

use App\Filament\Resources\Criterias\CriteriaResource;
use Filament\Resources\Pages\EditRecord;

class EditCriteria extends EditRecord
{
  protected static string $resource = CriteriaResource::class;

  protected function mutateFormDataBeforeFill(array $data): array
  {
    $data['name'] = (int) preg_replace('/[^0-9]/', '', $data['name']);
    return $data;
  }

  protected function getRedirectUrl(): string
  {
    $resource = static::getResource();
    return $resource::getUrl('index');
  }
}
