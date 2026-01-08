<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\EditProfile;
use Illuminate\Support\Facades\Auth;

class Profile extends EditProfile
{
  public static function canAccess(): bool
  {
    return Auth::id() === 1;
  }
}
