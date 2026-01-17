<?php

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
