<?php

namespace App\Filament\Resources\CriterionComparisons\Pages;

use App\Filament\Resources\CriterionComparisons\CriterionComparisonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCriterionComparison extends ViewRecord
{
    protected static string $resource = CriterionComparisonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
