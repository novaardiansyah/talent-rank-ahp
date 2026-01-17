<?php

/*
 * Project Name: talent-rank-ahp
 * File: ListAlternativeComparisons.php
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
use App\Jobs\AlternativeComparisonResource\ResetDataJob;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListAlternativeComparisons extends ListRecords
{
  protected static string $resource = AlternativeComparisonResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Action::make('reset')
        ->label('Reset Bobot')
        ->icon('heroicon-s-arrow-path')
        ->color('primary')
        ->requiresConfirmation()
        ->modalHeading('Reset bobot alternatif')
        ->action(function (Action $action) {
          ResetDataJob::dispatch(Auth::user());

          $action->success();
          $action->successNotification(
            Notification::make()
              ->success()
              ->title('Reset bobot alternatif sedang diproses')
              ->body('Anda akan menerima notifikasi setelah proses reset selesai')
          );
        })
    ];
  }
}
