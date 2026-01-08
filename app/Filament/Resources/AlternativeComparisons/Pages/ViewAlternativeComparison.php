<?php

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
