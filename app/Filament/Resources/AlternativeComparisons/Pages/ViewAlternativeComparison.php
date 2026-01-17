<?php

/*
 * Project Name: talent-rank-ahp
 * File: ViewAlternativeComparison.php
 * Created Date: Thursday January 8th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\AlternativeComparisons\Pages;

use App\Filament\Resources\AlternativeComparisons\AlternativeComparisonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAlternativeComparison extends ViewRecord
{
    protected static string $resource = AlternativeComparisonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
