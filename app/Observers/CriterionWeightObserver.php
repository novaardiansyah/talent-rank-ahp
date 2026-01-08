<?php

namespace App\Observers;

use App\Models\CriterionWeight;

class CriterionWeightObserver
{
  /**
   * Handle the User "created" event.
   */
  public function created(CriterionWeight $criteriaWeight): void
  {
    $this->_log('Created', $criteriaWeight);
  }

  /**
   * Handle the User "updated" event.
   */
  public function updated(CriterionWeight $criteriaWeight): void
  {
    $this->_log('Updated', $criteriaWeight);
  }

  /**
   * Handle the User "deleted" event.
   */
  public function deleted(CriterionWeight $criteriaWeight): void
  {
    $this->_log('Deleted', $criteriaWeight);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(CriterionWeight $criteriaWeight): void
  {
    $this->_log('Restored', $criteriaWeight);
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(CriterionWeight $criteriaWeight): void
  {
    $this->_log('Force Deleted', $criteriaWeight);
  }

  private function _log(string $event, CriterionWeight $criteriaWeight): void
  {
    saveActivityLog([
      'event'        => $event,
      'model'        => 'Criteria Weight',
      'subject_type' => CriterionWeight::class,
      'subject_id'   => $criteriaWeight->id,
    ], $criteriaWeight);
  }
}
