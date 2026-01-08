<?php

namespace App\Observers;

use App\Models\Alternative;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AlternativeObserver
{
  public function saving(Alternative $alternative): void
  {
    $alternative->name = sprintf('A%02d', $alternative->name);

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
    $this->_log('Deleted', $alternative);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(Alternative $alternative): void
  {
    $this->_log('Restored', $alternative);
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(Alternative $alternative): void
  {
    $this->_log('Force Deleted', $alternative);
  }

  private function _log(string $event, Alternative $alternative): void
  {
    saveActivityLog([
      'event'        => $event,
      'model'        => 'Alternative',
      'subject_type' => Alternative::class,
      'subject_id'   => $alternative->id,
    ], $alternative);
  }
}
