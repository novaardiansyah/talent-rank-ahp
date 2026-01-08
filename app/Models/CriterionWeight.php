<?php

namespace App\Models;

use App\Observers\CriterionWeightObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(CriterionWeightObserver::class)]
class CriterionWeight extends Model
{
  use SoftDeletes;
  
  protected $table = 'criterion_weights';

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
