<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  protected $table = 'users';

  protected $fillable = ['name', 'email', 'password', 'app_authentication_secret', 'app_authentication_recovery_codes'];

  protected $hidden = [
    'password',
    'remember_token',
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
}
