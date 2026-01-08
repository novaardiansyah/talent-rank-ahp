<?php

namespace App\Observers;

use App\Models\CriterionComparison;

class CriterionComparisonObserver
{
  /**
   * Handle the User "created" event.
   */
  public function created(CriterionComparison $criteriaComparison): void
  {
    $this->_log('Created', $criteriaComparison);
  }

  /**
   * Handle the User "updated" event.
   */
  public function updated(CriterionComparison $criteriaComparison): void
  {
    $this->_log('Updated', $criteriaComparison);
  }

  /**
   * Handle the User "deleted" event.
   */
  public function deleted(CriterionComparison $criteriaComparison): void
  {
    $this->_log('Deleted', $criteriaComparison);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(CriterionComparison $criteriaComparison): void
  {
    $this->_log('Restored', $criteriaComparison);
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(CriterionComparison $criteriaComparison): void
  {
    $this->_log('Force Deleted', $criteriaComparison);
  }

  private function _log(string $event, CriterionComparison $criteriaComparison): void
  {
    saveActivityLog([
      'event'        => $event,
      'model'        => 'Criteria Comparison',
      'subject_type' => CriterionComparison::class,
      'subject_id'   => $criteriaComparison->id,
    ], $criteriaComparison);
  }
}
