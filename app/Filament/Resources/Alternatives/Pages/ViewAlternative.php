<?php

/*
 * Project Name: talent-rank-ahp
 * File: ViewAlternative.php
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
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAlternative extends ViewRecord
{
    protected static string $resource = AlternativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
