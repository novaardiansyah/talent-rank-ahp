<?php

namespace App\Filament\Resources\AlternativeComparisons\Pages;

use App\Filament\Resources\AlternativeComparisons\AlternativeComparisonResource;
use App\Models\Alternative;
use App\Models\AlternativeComparison;
use App\Models\Criteria;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

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
          AlternativeComparison::truncate();

          $criterias = Criteria::all();
          $alternatives = Alternative::all();

          $temp = [];
          $now = Carbon::now();

          foreach ($criterias as $criteria) {
            foreach ($alternatives as $alternative) {
              foreach ($alternatives as $alternative2) {
                $temp[] = [
                  'criterion_id'     => $criteria->id,
                  'alternative_id_1' => $alternative->id,
                  'alternative_id_2' => $alternative2->id,
                  'value'            => 1,
                  'created_at'       => $now,
                  'updated_at'       => $now,
                ];
              }
            }
          }

          AlternativeComparison::insert($temp);

          $action->success();
          $action->successNotification(
            Notification::make()
              ->success()
              ->title('Berhasil reset bobot alternatif')
              ->body('Seluruh bobot alternatif berhasil direset kembali ke default')
          );
        })
    ];
  }
}
