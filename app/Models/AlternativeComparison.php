<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlternativeComparison extends Model
{
  use SoftDeletes;

  protected $table = 'alternative_comparisons';

  protected $fillable = ['criterion_id', 'alternative_id_1', 'alternative_id_2', 'value'];

  public function criterion(): BelongsTo
  {
    return $this->belongsTo(Criteria::class);
  }

  public function primaryAlternative(): BelongsTo
  {
    return $this->belongsTo(Alternative::class, 'alternative_id_1');
  }

  public function comparisonAlternative(): BelongsTo
  {
    return $this->belongsTo(Alternative::class, 'alternative_id_2');
  }
}
