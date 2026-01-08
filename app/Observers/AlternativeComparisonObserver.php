<?php

namespace App\Observers;

use App\Models\AlternativeComparison;

class AlternativeComparisonObserver
{
  /**
   * Handle the User "created" event.
   */
  public function created(AlternativeComparison $alternativeComparison): void
  {
    $this->_log('Created', $alternativeComparison);
  }

  /**
   * Handle the User "updated" event.
   */
  public function updated(AlternativeComparison $alternativeComparison): void
  {
    $this->_log('Updated', $alternativeComparison);
  }

  /**
   * Handle the User "deleted" event.
   */
  public function deleted(AlternativeComparison $alternativeComparison): void
  {
    $this->_log('Deleted', $alternativeComparison);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(AlternativeComparison $alternativeComparison): void
  {
    $this->_log('Restored', $alternativeComparison);
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(AlternativeComparison $alternativeComparison): void
  {
    $this->_log('Force Deleted', $alternativeComparison);
  }

  private function _log(string $event, AlternativeComparison $alternativeComparison): void
  {
    saveActivityLog([
      'event'        => $event,
      'model'        => 'Alternative Comparison',
      'subject_type' => AlternativeComparison::class,
      'subject_id'   => $alternativeComparison->id,
    ], $alternativeComparison);
  }
}
