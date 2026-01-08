<?php

namespace App\Models;

use App\Observers\AlternativeComparisonObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(AlternativeComparisonObserver::class)]
class AlternativeComparison extends Model
{
  use SoftDeletes;

  protected $table = 'alternative_comparisons';

  protected $fillable = ['criterion_id', 'alternative_id_1', 'alternative_id_2', 'value'];
}
