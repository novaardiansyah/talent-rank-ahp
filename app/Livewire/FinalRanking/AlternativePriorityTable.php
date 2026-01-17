<?php

namespace App\Livewire\FinalRanking;

use App\Services\AlternativeMatrixService;
use App\Services\CriteriaMatrixService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TableComponent;

class AlternativePriorityTable extends TableComponent
{
  public int $criteriaId;

  protected AlternativeMatrixService $matrixService;

  public function boot(): void
  {
    $this->matrixService = new AlternativeMatrixService();
  }

  public function table(Table $table): Table
  {
    $alternatives = collect($this->matrixService->getAlternatives());
    $matrixData = $this->matrixService->getMatrixByCriteria($this->criteriaId);
    $normalizedMatrix = $matrixData['normalized'];
    $priorities = $matrixData['priorities'];
    $consistencyMeasures = $matrixData['consistencyMeasures'];

    $records = [];
    foreach ($alternatives as $row) {
      $record = [
        'id' => $row['id'],
        'code' => 'A' . str_pad($row['id'], 2, '0', STR_PAD_LEFT),
      ];

      foreach ($alternatives as $col) {
        $record['a_' . $col['id']] = $normalizedMatrix[$row['id']][$col['id']] ?? 0;
      }

      $record['priority'] = $priorities[$row['id']] ?? 0;
      $record['cm'] = $consistencyMeasures[$row['id']] ?? 0;
      $records[$row['id']] = $record;
    }

    $columns = [
      TextColumn::make('code')
        ->label('Kode')
        ->weight('bold'),
    ];

    foreach ($alternatives as $a) {
      $columns[] = TextColumn::make('a_' . $a['id'])
        ->label('A' . str_pad($a['id'], 2, '0', STR_PAD_LEFT))
        ->alignCenter()
        ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue((float) $state, 3));
    }

    $columns[] = TextColumn::make('priority')
      ->label('Prioritas')
      ->alignCenter()
      ->weight('bold')
      ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue((float) $state, 3));

    $columns[] = TextColumn::make('cm')
      ->label('CM')
      ->alignCenter()
      ->weight('bold')
      ->color('primary')
      ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue((float) $state, 3));

    return $table
      ->records(fn(): array => $records)
      ->columns($columns)
      ->paginated(false);
  }

  public function getCriteriaName(): string
  {
    $criterias = $this->matrixService->getCriterias();
    foreach ($criterias as $c) {
      if ($c['id'] === $this->criteriaId) {
        return $c['description'];
      }
    }
    return '';
  }

  public function getConsistencyIndex(): float
  {
    return $this->matrixService->getMatrixByCriteria($this->criteriaId)['consistencyIndex'] ?? 0;
  }

  public function getRatioIndex(): float
  {
    return $this->matrixService->getMatrixByCriteria($this->criteriaId)['ratioIndex'] ?? 0;
  }

  public function getConsistencyRatio(): float
  {
    return $this->matrixService->getMatrixByCriteria($this->criteriaId)['consistencyRatio'] ?? 0;
  }

  public function render()
  {
    return view('livewire.final-ranking.alternative-priority-table');
  }
}
