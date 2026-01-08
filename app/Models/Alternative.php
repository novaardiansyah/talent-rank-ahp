<?php

namespace App\Models;

use App\Observers\AlternativeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(AlternativeObserver::class)]
class Alternative extends Model
{
  use SoftDeletes;

  protected $table = 'alternatives';

  protected $fillable = ['name', 'description'];
}
