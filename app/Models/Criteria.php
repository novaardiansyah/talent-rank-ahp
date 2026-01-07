<?php

namespace App\Models;

use App\Observers\CriteriaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(CriteriaObserver::class)]
class Criteria extends Model
{
  use SoftDeletes;

  protected $table = 'criterias';

  protected $fillable = ['name', 'description'];


}
