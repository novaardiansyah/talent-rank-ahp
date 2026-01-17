<?php

namespace App\Observers;

use App\Models\Alternative;
use App\Models\AlternativeComparison;
use App\Models\Criteria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AlternativeObserver
{
  public function saving(Alternative $alternative): void
  {
    $alternative->name = sprintf('A%02d', preg_replace('/[^0-9]/', '', $alternative->name));

    $validator = Validator::make($alternative->getAttributes(), [
      'name' => ['required', Rule::unique('alternatives', 'name')->ignore($alternative->id)],
    ], [], ['name' => 'kode alternatif']);

    if ($validator->fails()) {
      $errors = $validator->errors()->toArray();
      throw ValidationException::withMessages(normalizeValidationErrors($errors, 'data.'));
    }
  }

  /**
   * Handle the User "created" event.
   */
  public function created(Alternative $alternative): void
  {
    $criterias = Criteria::all();
    $others = Alternative::where('id', '!=', $alternative->id)->get();

    foreach ($criterias as $criteria) {
      foreach ($others as $other) {
        AlternativeComparison::firstOrCreate([
          'criterion_id' => $criteria->id,
          'alternative_id_1' => min($alternative->id, $other->id),
          'alternative_id_2' => max($alternative->id, $other->id),
        ], [
          'value' => 1,
        ]);
      }
    }

    $this->_log('Created', $alternative);
  }

  /**
   * Handle the User "updated" event.
   */
  public function updated(Alternative $alternative): void
  {
    $this->_log('Updated', $alternative);
  }

  /**
   * Handle the User "deleted" event.
   */
  public function deleted(Alternative $alternative): void
  {
    AlternativeComparison::where('alternative_id_1', $alternative->id)
      ->orWhere('alternative_id_2', $alternative->id)
      ->delete();

    $this->_log('Deleted', $alternative);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(Alternative $alternative): void
  {
    AlternativeComparison::withTrashed()
      ->where('alternative_id_1', $alternative->id)
      ->orWhere('alternative_id_2', $alternative->id)
      ->restore();

    $this->_log('Restored', $alternative);
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(Alternative $alternative): void
  {
    AlternativeComparison::withTrashed()
      ->where('alternative_id_1', $alternative->id)
      ->orWhere('alternative_id_2', $alternative->id)
      ->forceDelete();

    $this->_log('Force Deleted', $alternative);
  }

  private function _log(string $event, Alternative $alternative): void
  {
    saveActivityLog([
      'event' => $event,
      'model' => 'Alternative',
      'subject_type' => Alternative::class,
      'subject_id' => $alternative->id,
    ], $alternative);
  }
}
