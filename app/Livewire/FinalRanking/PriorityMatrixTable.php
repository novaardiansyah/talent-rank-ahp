<?php

namespace App\Livewire\FinalRanking;

use App\Services\CriteriaMatrixService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TableComponent;

class PriorityMatrixTable extends TableComponent
{
  protected CriteriaMatrixService $matrixService;

  public function boot(): void
  {
    $this->matrixService = new CriteriaMatrixService();
  }

  public function table(Table $table): Table
  {
    $criterias = collect($this->matrixService->getCriterias());
    $normalizedMatrix = $this->matrixService->getNormalizedMatrix();
    $priorities = $this->matrixService->getPriorities();

    $records = [];
    foreach ($criterias as $row) {
      $record = [
        'id' => $row['id'],
        'code' => 'C' . str_pad($row['id'], 2, '0', STR_PAD_LEFT),
      ];

      foreach ($criterias as $col) {
        $record['c_' . $col['id']] = $normalizedMatrix[$row['id']][$col['id']];
      }

      $record['priority'] = $priorities[$row['id']];
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
      ->weight('bold')
      ->color('primary')
      ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue($state, 3));

    return $table
      ->records(fn(): array => $records)
      ->columns($columns)
      ->paginated(false);
  }

  public function render()
  {
    return view('livewire.final-ranking.priority-matrix-table');
  }
}
