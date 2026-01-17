<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\AlternativeComparison;
use App\Models\Criteria;

class AlternativeMatrixService
{
  protected array $criterias = [];
  protected array $alternatives = [];
  protected array $matrices = [];

  public function __construct()
  {
    $this->calculate();
  }

  protected function calculate(): void
  {
    $this->criterias = Criteria::orderBy('id')->get()->toArray();
    $this->alternatives = Alternative::orderBy('id')->get()->toArray();
    $comparisons = AlternativeComparison::all();

    $rawMatrix = [];
    foreach ($comparisons as $comp) {
      $rawMatrix[$comp->criterion_id][$comp->alternative_id_1][$comp->alternative_id_2] = $comp->value;
    }

    foreach ($this->criterias as $criteria) {
      $criteriaId = $criteria['id'];
      $matrix = [];
      $columnTotals = [];

      foreach ($this->alternatives as $alt) {
        $columnTotals[$alt['id']] = 0;
      }

      foreach ($this->alternatives as $row) {
        foreach ($this->alternatives as $col) {
          if ($row['id'] === $col['id']) {
            $value = 1;
          } elseif (isset($rawMatrix[$criteriaId][$row['id']][$col['id']])) {
            $value = $rawMatrix[$criteriaId][$row['id']][$col['id']];
          } elseif (isset($rawMatrix[$criteriaId][$col['id']][$row['id']])) {
            $value = 1 / $rawMatrix[$criteriaId][$col['id']][$row['id']];
          } else {
            $value = 1;
          }

          $matrix[$row['id']][$col['id']] = $value;
          $columnTotals[$col['id']] += $value;
        }
      }
      $normalizedMatrix = [];
      $priorities = [];
      $consistencyMeasures = [];

      foreach ($this->alternatives as $row) {
        $rowSum = 0;
        foreach ($this->alternatives as $col) {
          $normalizedValue = $matrix[$row['id']][$col['id']] / $columnTotals[$col['id']];
          $normalizedMatrix[$row['id']][$col['id']] = $normalizedValue;
          $rowSum += $normalizedValue;
        }
        $priorities[$row['id']] = $rowSum / count($this->alternatives);
      }

      $n = count($this->alternatives);
      foreach ($this->alternatives as $row) {
        $weightedSum = 0;
        foreach ($this->alternatives as $col) {
          $weightedSum += $matrix[$row['id']][$col['id']] * $priorities[$col['id']];
        }
        $consistencyMeasures[$row['id']] = $weightedSum / $priorities[$row['id']];
      }

      $lambdaMax = array_sum($consistencyMeasures) / $n;
      $consistencyIndex = ($n > 1) ? ($lambdaMax - $n) / ($n - 1) : 0;
      $ratioIndex = CriteriaMatrixService::RI_TABLE[$n] ?? 1.49;
      $consistencyRatio = ($ratioIndex > 0) ? $consistencyIndex / $ratioIndex : 0;

      $this->matrices[$criteriaId] = [
        'comparison' => $matrix,
        'totals' => $columnTotals,
        'normalized' => $normalizedMatrix,
        'priorities' => $priorities,
        'consistencyMeasures' => $consistencyMeasures,
        'consistencyIndex' => $consistencyIndex,
        'ratioIndex' => $ratioIndex,
        'consistencyRatio' => $consistencyRatio,
      ];
    }
  }

  public function getCriterias(): array
  {
    return $this->criterias;
  }

  public function getAlternatives(): array
  {
    return $this->alternatives;
  }

  public function getMatrixByCriteria(int $criteriaId): array
  {
    return $this->matrices[$criteriaId] ?? ['comparison' => [], 'totals' => []];
  }

  public function getAllMatrices(): array
  {
    return $this->matrices;
  }
}
