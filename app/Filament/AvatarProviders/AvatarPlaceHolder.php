<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AvatarPlaceHolder implements Contracts\AvatarProvider
{
  public function get(Model|Authenticatable $record): string
  {
    $rand = ['boy', 'girl'];
    $url = 'https://avatar.iran.liara.run/public/' . $rand[rand(0, 1)] . '?username=' . $record->name;

    $record->avatar_url = $url;
    $record->save();

    return $record->avatar_url;
  }
}
