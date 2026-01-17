<?php

namespace App\Livewire\FinalRanking;

use App\Services\CriteriaMatrixService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TableComponent;

class ConsistencyMatrixTable extends TableComponent
{
  protected CriteriaMatrixService $matrixService;

  public function boot(): void
  {
    $this->matrixService = new CriteriaMatrixService();
  }

  public function table(Table $table): Table
  {
    $criterias = collect($this->matrixService->getCriterias());
    $consistencyMatrix = $this->matrixService->getConsistencyMatrix();
    $priorities = $this->matrixService->getPriorities();
    $consistencyMeasures = $this->matrixService->getConsistencyMeasures();

    $records = [];
    foreach ($criterias as $row) {
      $record = [
        'id' => $row['id'],
        'code' => 'C' . str_pad($row['id'], 2, '0', STR_PAD_LEFT),
      ];

      foreach ($criterias as $col) {
        $record['c_' . $col['id']] = $consistencyMatrix[$row['id']][$col['id']];
      }

      $record['priority'] = $priorities[$row['id']];
      $record['consistency_measure'] = $consistencyMeasures[$row['id']];
      $records[$row['id']] = $record;
    }

    $columns = [
      TextColumn::make('code')
        ->label('Kode')
        ->weight('bold'),
    ];

    foreach ($criterias as $c) {
      $columns[] = TextColumn::make('c_' . $c['id'])
        ->label('C' . str_pad($c['id'], 2, '0', STR_PAD_LEFT))
        ->alignCenter()
        ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue($state, 3));
    }

    $columns[] = TextColumn::make('priority')
      ->label('Prioritas')
      ->alignCenter()
      ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue($state, 3));

    $columns[] = TextColumn::make('consistency_measure')
      ->label('Consistency Measure')
      ->alignCenter()
      ->weight('bold')
      ->color('primary')
      ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue($state, 3));

    return $table
      ->records(fn(): array => $records)
      ->columns($columns)
      ->paginated(false);
  }

  public function getConsistencyIndex(): float
  {
    return $this->matrixService->getConsistencyIndex();
  }

  public function getRatioIndex(): float
  {
    return $this->matrixService->getRatioIndex();
  }

  public function getConsistencyRatio(): float
  {
    return $this->matrixService->getConsistencyRatio();
  }

  public function render()
  {
    return view('livewire.final-ranking.consistency-matrix-table');
  }
}
