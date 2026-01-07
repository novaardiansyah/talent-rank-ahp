<?php

namespace App\Observers;

use App\Models\Criteria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CriteriaObserver
{
  public function saving(Criteria $criteria): void
  {
    $criteria->name = sprintf('C%02d', $criteria->name);

    $validator = Validator::make($criteria->getAttributes(), [
      'name' => ['required', Rule::unique('criterias', 'name')->ignore($criteria->id)],
    ], [], ['name' => 'kode kriteria']);

    if ($validator->fails()) {
      $errors = $validator->errors()->toArray();
      throw ValidationException::withMessages(normalizeValidationErrors($errors, 'data.'));
    }
  }

  /**
   * Handle the User "created" event.
   */
  public function created(Criteria $criteria): void
  {
    $this->_log('Created', $criteria);
  }

  /**
   * Handle the User "updated" event.
   */
  public function updated(Criteria $criteria): void
  {
    $this->_log('Updated', $criteria);
  }

  /**
   * Handle the User "deleted" event.
   */
  public function deleted(Criteria $criteria): void
  {
    $this->_log('Deleted', $criteria);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(Criteria $criteria): void
  {
    $this->_log('Restored', $criteria);
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(Criteria $criteria): void
  {
    $this->_log('Force Deleted', $criteria);
  }

  private function _log(string $event, Criteria $criteria): void
  {
    saveActivityLog([
      'event' => $event,
      'model' => 'Criteria',
      'subject_type' => Criteria::class,
      'subject_id' => $criteria->id,
    ], $criteria);
  }
}
