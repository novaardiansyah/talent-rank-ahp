<?php

namespace App\Jobs\AlternativeComparisonResource;

use App\Models\ActivityLog;
use App\Models\Alternative;
use App\Models\AlternativeComparison;
use App\Models\Criteria;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Filament\Actions\Action;

class ResetDataJob implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new job instance.
   */
  public function __construct(public User $user)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    AlternativeComparison::truncate();

    $criterias = Criteria::all();
    $alternatives = Alternative::all();

    $temp = [];
    $now = Carbon::now();

    $logs = [];
    $batch_uuid = uuid();

    foreach ($criterias as $criteria) {
      foreach ($alternatives as $alternative) {
        foreach ($alternatives as $alternative2) {
          $properties = [
            'criterion_id'     => $criteria->id,
            'alternative_id_1' => $alternative->id,
            'alternative_id_2' => $alternative2->id,
            'value'            => 1,
            'created_at'       => $now,
            'updated_at'       => $now,
          ];

          $logs[] = [
            'log_name'    => 'Resource',
            'event'       => 'Created Bulk',
            'description' => 'Alternative Comparison Created Bulk by ' . $this->user->name,
            'causer_type' => User::class,
            'causer_id'   => $this->user->id,
            'properties'  => json_encode($properties),
            'batch_uuid'  => $batch_uuid,
            'created_at'  => $now,
            'updated_at'  => $now,
          ];

          $temp[] = $properties;
        }
      }
    }

    AlternativeComparison::insert($temp);
    ActivityLog::insert($logs);

    Notification::make()
      ->success()
      ->title('Berhasil reset bobot alternatif')
      ->body('Seluruh bobot alternatif berhasil direset kembali ke default')
      ->actions([
        Action::make('view')
          ->label('Lihat Data')
          ->url(route('filament.admin.resources.alternative-comparisons.index'))
          ->markAsRead()
      ])
      ->sendToDatabase($this->user);
  }
}
