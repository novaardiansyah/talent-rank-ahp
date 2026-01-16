<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\CriterionComparison;

class CriteriaMatrixService
{
  protected array $criterias = [];
  protected array $comparisonMatrix = [];
  protected array $columnTotals = [];
  protected array $normalizedMatrix = [];
  protected array $priorities = [];

  public function __construct()
  {
    $this->calculate();
  }

  protected function calculate(): void
  {
    $criterias = Criteria::orderBy('id')->get();
    $this->criterias = $criterias->toArray();
    $comparisons = CriterionComparison::all();

    $matrix = [];
    foreach ($comparisons as $comp) {
      $matrix[$comp->criterion_id_1][$comp->criterion_id_2] = $comp->value;
    }

    // Initialize column totals
    foreach ($criterias as $col) {
      $this->columnTotals[$col->id] = 0;
    }

    // Build comparison matrix
    foreach ($criterias as $row) {
      foreach ($criterias as $col) {
        if ($row->id === $col->id) {
          $value = 1;
        } elseif (isset($matrix[$row->id][$col->id])) {
          $value = $matrix[$row->id][$col->id];
        } elseif (isset($matrix[$col->id][$row->id])) {
          $value = 1 / $matrix[$col->id][$row->id];
        } else {
          $value = 1;
        }

        $this->comparisonMatrix[$row->id][$col->id] = $value;
        $this->columnTotals[$col->id] += $value;
      }
    }

    // Build normalized matrix and calculate priorities
    foreach ($criterias as $row) {
      $rowSum = 0;
      foreach ($criterias as $col) {
        $normalizedValue = $this->comparisonMatrix[$row->id][$col->id] / $this->columnTotals[$col->id];
        $this->normalizedMatrix[$row->id][$col->id] = $normalizedValue;
        $rowSum += $normalizedValue;
      }
      $this->priorities[$row->id] = $rowSum / count($criterias);
    }
  }

  public function getCriterias(): array
  {
    return $this->criterias;
  }

  public function getComparisonMatrix(): array
  {
    return $this->comparisonMatrix;
  }

  public function getColumnTotals(): array
  {
    return $this->columnTotals;
  }

  public function getNormalizedMatrix(): array
  {
    return $this->normalizedMatrix;
  }

  public function getPriorities(): array
  {
    return $this->priorities;
  }

  public static function formatValue(float $value, int $decimals = 4): string
  {
    if ($value == (int) $value) {
      return (string) (int) $value;
    }
    return rtrim(rtrim(number_format($value, $decimals, '.', ''), '0'), '.');
  }
}
