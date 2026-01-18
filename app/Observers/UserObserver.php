<?php

/*
 * Project Name: talent-rank-ahp
 * File: UserObserver.php
 * Created Date: Wednesday January 7th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Observers;

use App\Models\User;

class UserObserver
{
  public function creating(User $user)
  {
    if (!$user->avatar_url) {
      $user->avatar_url = 'https://testingbot.com/free-online-tools/random-avatar/300?u=' . $user->id;
    }
  }

  /**
   * Handle the User "created" event.
   */
  public function created(User $user): void
  {
    $this->_log('Created', $user);
  }

  public function updating(User $user): void
  {
    if (empty($user->password)) {
      unset($user->password);
    }
  }

  /**
   * Handle the User "updated" event.
   */
  public function updated(User $user): void
  {
    $this->_log('Updated', $user);
  }

  /**
   * Handle the User "deleted" event.
   */
  public function deleted(User $user): void
  {
    $this->_log('Deleted', $user);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(User $user): void
  {
    $this->_log('Restored', $user);
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(User $user): void
  {
    $this->_log('Force Deleted', $user);
  }

  private function _log(string $event, User $user): void
  {
    saveActivityLog([
      'event'        => $event,
      'model'        => 'User',
      'subject_type' => User::class,
      'subject_id'   => $user->id,
    ], $user);
  }
}
