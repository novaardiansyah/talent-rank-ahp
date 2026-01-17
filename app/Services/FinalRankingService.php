<?php

namespace App\Services;

class FinalRankingService
{
  protected CriteriaMatrixService $criteriaService;
  protected AlternativeMatrixService $alternativeService;
  protected array $finalScores = [];
  protected array $rankings = [];

  public function __construct()
  {
    $this->criteriaService = new CriteriaMatrixService();
    $this->alternativeService = new AlternativeMatrixService();
    $this->calculate();
  }

  protected function calculate(): void
  {
    $criterias = $this->criteriaService->getCriterias();
    $criteriaPriorities = $this->criteriaService->getPriorities();
    $alternatives = $this->alternativeService->getAlternatives();

    foreach ($alternatives as $alt) {
      $totalScore = 0;
      $scores = [];

      foreach ($criterias as $criteria) {
        $altPriorities = $this->alternativeService->getMatrixByCriteria($criteria['id'])['priorities'] ?? [];
        $altPriority = $altPriorities[$alt['id']] ?? 0;
        $critPriority = $criteriaPriorities[$criteria['id']] ?? 0;
        $weightedScore = $altPriority * $critPriority;
        $scores[$criteria['id']] = $weightedScore;
        $totalScore += $weightedScore;
      }

      $this->finalScores[$alt['id']] = [
        'alternative' => $alt,
        'scores' => $scores,
        'total' => $totalScore,
      ];
    }

    uasort($this->finalScores, fn($a, $b) => $b['total'] <=> $a['total']);

    $rank = 1;
    foreach ($this->finalScores as $altId => $data) {
      $this->rankings[$altId] = $rank++;
    }
  }

  public function getCriterias(): array
  {
    return $this->criteriaService->getCriterias();
  }

  public function getCriteriaPriorities(): array
  {
    return $this->criteriaService->getPriorities();
  }

  public function getAlternatives(): array
  {
    return $this->alternativeService->getAlternatives();
  }

  public function getFinalScores(): array
  {
    return $this->finalScores;
  }

  public function getRankings(): array
  {
    return $this->rankings;
  }

  public function getRankingDescription(): string
  {
    $parts = [];
    foreach ($this->finalScores as $altId => $data) {
      $name = $data['alternative']['description'];
      $rank = $this->rankings[$altId];
      $total = CriteriaMatrixService::formatValue($data['total'], 3);
      $parts[] = "<strong>{$name}</strong> mendapat rangking {$rank} dengan nilai {$total}";
    }
    return "Berdasarkan hasil perhitungan diperoleh: " . implode(", ", $parts);
  }
}
