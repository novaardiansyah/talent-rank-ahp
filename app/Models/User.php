<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthenticationRecovery;
use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser, HasAppAuthentication, HasAppAuthenticationRecovery, HasEmailAuthentication, MustVerifyEmail, HasAvatar
{
  use HasFactory, Notifiable, HasRoles;

  protected $table = 'users';

  protected $fillable = ['name', 'email', 'password', 'app_authentication_secret', 'app_authentication_recovery_codes', 'avatar_url'];

  protected $hidden = [
    'password',
    'remember_token',
    'app_authentication_secret',
    'app_authentication_recovery_codes',
  ];

  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
      'app_authentication_secret' => 'encrypted',
      'app_authentication_recovery_codes' => 'encrypted:array',
      'has_email_authentication' => 'boolean',
    ];
  }

  public function canAccessPanel(Panel $panel): bool
  {
    if ($panel->getId() === 'admin') {
      return str_ends_with($this->email, '@novaardiansyah.id') && $this->hasVerifiedEmail();
    }
    return true;
  }

  public function getAppAuthenticationSecret(): ?string
  {
    return $this->app_authentication_secret;
  }

  public function saveAppAuthenticationSecret(?string $secret): void
  {
    $this->app_authentication_secret = $secret;
    $this->save();
  }

  public function getAppAuthenticationHolderName(): string
  {
    return $this->email;
  }

  public function getAppAuthenticationRecoveryCodes(): ?array
  {
    return $this->app_authentication_recovery_codes;
  }

  public function saveAppAuthenticationRecoveryCodes(?array $codes): void
  {
    $this->app_authentication_recovery_codes = $codes;
    $this->save();
  }

  public function hasEmailAuthentication(): bool
  {
    return $this->has_email_authentication;
  }

  public function toggleEmailAuthentication(bool $condition): void
  {
    $this->has_email_authentication = $condition;
    $this->save();
  }

  public function getFilamentAvatarUrl(): ?string
  {
    return $this->avatar_url;
  }
}
