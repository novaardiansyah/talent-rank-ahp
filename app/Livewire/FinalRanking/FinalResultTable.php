<?php

namespace App\Livewire\FinalRanking;

use App\Services\CriteriaMatrixService;
use App\Services\FinalRankingService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TableComponent;

class FinalResultTable extends TableComponent
{
  protected FinalRankingService $rankingService;

  public function boot(): void
  {
    $this->rankingService = new FinalRankingService();
  }

  public function table(Table $table): Table
  {
    $criterias = collect($this->rankingService->getCriterias());
    $criteriaPriorities = $this->rankingService->getCriteriaPriorities();
    $finalScores = $this->rankingService->getFinalScores();
    $rankings = $this->rankingService->getRankings();

    $headerRecord = [
      'id' => 'header',
      'code' => '',
      'name' => '',
    ];
    foreach ($criterias as $c) {
      $headerRecord['c_' . $c['id']] = $criteriaPriorities[$c['id']] ?? 0;
    }
    $headerRecord['total'] = '';
    $headerRecord['rank'] = '';

    $records = ['header' => $headerRecord];

    foreach ($finalScores as $altId => $data) {
      $record = [
        'id' => $altId,
        'code' => 'A' . str_pad($altId, 2, '0', STR_PAD_LEFT),
        'name' => $data['alternative']['description'],
      ];

      foreach ($criterias as $c) {
        $record['c_' . $c['id']] = $data['scores'][$c['id']] ?? 0;
      }

      $record['total'] = $data['total'];
      $record['rank'] = $rankings[$altId];
      $records[$altId] = $record;
    }

    $columns = [
      TextColumn::make('code')
        ->label('Kode')
        ->weight('bold'),
      TextColumn::make('name')
        ->label('Nama'),
    ];

    foreach ($criterias as $c) {
      $columns[] = TextColumn::make('c_' . $c['id'])
        ->label('C' . str_pad($c['id'], 2, '0', STR_PAD_LEFT))
        ->alignCenter()
        ->formatStateUsing(fn($state) => $state !== '' ? CriteriaMatrixService::formatValue((float) $state, 3) : '');
    }

    $columns[] = TextColumn::make('total')
      ->label('Total')
      ->alignCenter()
      ->weight('bold')
      ->formatStateUsing(fn($state) => $state !== '' ? CriteriaMatrixService::formatValue((float) $state, 3) : '');

    $columns[] = TextColumn::make('rank')
      ->label('Rank')
      ->alignCenter()
      ->weight('bold')
      ->color('primary');

    return $table
      ->records(fn(): array => $records)
      ->columns($columns)
      ->paginated(false);
  }

  public function getRankingDescription(): string
  {
    return $this->rankingService->getRankingDescription();
  }

  public function render()
  {
    return view('livewire.final-ranking.final-result-table');
  }
}
