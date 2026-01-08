<?php

namespace App\Models;

use App\Observers\CriterionComparisonObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(CriterionComparisonObserver::class)]
class CriterionComparison extends Model
{
  use SoftDeletes;

  protected $table = 'criterion_comparisons';

  protected $fillable = [
    'criterion_id_1',
    'criterion_id_2',
    'value',
  ];

  public function primaryCriterion()
  {
    return $this->belongsTo(Criteria::class, 'criterion_id_1');
  }

  public function comparisonCriterion()
  {
    return $this->belongsTo(Criteria::class, 'criterion_id_2');
  }
}
