<?php

namespace App\Livewire\FinalRanking;

use App\Services\AlternativeMatrixService;
use App\Services\CriteriaMatrixService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TableComponent;

class AlternativeComparisonTable extends TableComponent
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
    $comparisonMatrix = $matrixData['comparison'];
    $totals = $matrixData['totals'];

    $records = [];
    foreach ($alternatives as $row) {
      $record = [
        'id' => $row['id'],
        'code' => 'A' . str_pad($row['id'], 2, '0', STR_PAD_LEFT),
        'name' => $row['name'],
      ];

      foreach ($alternatives as $col) {
        $record['a_' . $col['id']] = $comparisonMatrix[$row['id']][$col['id']] ?? 1;
      }

      $records[$row['id']] = $record;
    }

    $totalRecord = [
      'id' => 'total',
      'code' => 'Total',
      'name' => '',
    ];
    foreach ($alternatives as $col) {
      $totalRecord['a_' . $col['id']] = $totals[$col['id']] ?? 0;
    }
    $records['total'] = $totalRecord;

    $columns = [
      TextColumn::make('code')
        ->label('Kode')
        ->weight('bold'),
      TextColumn::make('name')
        ->label('Nama'),
    ];

    foreach ($alternatives as $a) {
      $columns[] = TextColumn::make('a_' . $a['id'])
        ->label('A' . str_pad($a['id'], 2, '0', STR_PAD_LEFT))
        ->alignCenter()
        ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue((float) $state, 3));
    }

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

  public function render()
  {
    return view('livewire.final-ranking.alternative-comparison-table');
  }
}
