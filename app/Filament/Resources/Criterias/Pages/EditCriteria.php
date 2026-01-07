<?php

namespace App\Filament\Resources\Payments\Pages;

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
