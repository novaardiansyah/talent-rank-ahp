<?php

/*
 * Project Name: talent-rank-ahp
 * File: ManageActivityLogs.php
 * Created Date: Wednesday January 7th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\ActivityLogs\Pages;

use App\Filament\Resources\ActivityLogs\ActivityLogResource;
use Filament\Resources\Pages\ManageRecords;

class ManageActivityLogs extends ManageRecords
{
  protected static string $resource = ActivityLogResource::class;

  protected function getHeaderActions(): array
  {
    return [
      // CreateAction::make(),
    ];
  }
}
