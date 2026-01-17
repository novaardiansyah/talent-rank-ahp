<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\CriterionComparison;

class CriteriaMatrixService
{
  public const RI_TABLE = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.9, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.46, 10 => 1.49];

  protected array $criterias = [];
  protected array $comparisonMatrix = [];
  protected array $columnTotals = [];
  protected array $normalizedMatrix = [];
  protected array $priorities = [];
  protected array $consistencyMatrix = [];
  protected array $consistencyMeasures = [];
  protected float $consistencyIndex = 0;
  protected float $ratioIndex = 0;
  protected float $consistencyRatio = 0;

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

    foreach ($criterias as $col) {
      $this->columnTotals[$col->id] = 0;
    }

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

    foreach ($criterias as $row) {
      $rowSum = 0;
      foreach ($criterias as $col) {
        $normalizedValue = $this->comparisonMatrix[$row->id][$col->id] / $this->columnTotals[$col->id];
        $this->normalizedMatrix[$row->id][$col->id] = $normalizedValue;
        $rowSum += $normalizedValue;
      }
      $this->priorities[$row->id] = $rowSum / count($criterias);
    }


    $n = count($criterias);

    foreach ($criterias as $row) {
      $weightedSum = 0;
      foreach ($criterias as $col) {
        $weightedSum += $this->comparisonMatrix[$row->id][$col->id] * $this->priorities[$col->id];
        $this->consistencyMatrix[$row->id][$col->id] = $this->comparisonMatrix[$row->id][$col->id] * $this->priorities[$col->id];
      }
      $this->consistencyMeasures[$row->id] = $weightedSum / $this->priorities[$row->id];
    }

    $lambdaMax = array_sum($this->consistencyMeasures) / $n;
    $this->consistencyIndex = ($lambdaMax - $n) / ($n - 1);
    $this->ratioIndex = self::RI_TABLE[$n] ?? 1.49;
    $this->consistencyRatio = $this->consistencyIndex / $this->ratioIndex;
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

  public function getConsistencyMatrix(): array
  {
    return $this->consistencyMatrix;
  }

  public function getConsistencyMeasures(): array
  {
    return $this->consistencyMeasures;
  }

  public function getConsistencyIndex(): float
  {
    return $this->consistencyIndex;
  }

  public function getRatioIndex(): float
  {
    return $this->ratioIndex;
  }

  public function getConsistencyRatio(): float
  {
    return $this->consistencyRatio;
  }

  public static function formatValue(float $value, int $decimals = 4): string
  {
    if ($value == (int) $value) {
      return (string) (int) $value;
    }
    return rtrim(rtrim(number_format($value, $decimals, '.', ''), '0'), '.');
  }
}
