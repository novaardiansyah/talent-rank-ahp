<?php

/*
 * Project Name: talent-rank-ahp
 * File: CreateAlternative.php
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
use Filament\Resources\Pages\CreateRecord;

class CreateAlternative extends CreateRecord
{
  protected static string $resource = AlternativeResource::class;
  protected function getRedirectUrl(): string
  {
    $resource = static::getResource();
    return $resource::getUrl('index');
  }
}
