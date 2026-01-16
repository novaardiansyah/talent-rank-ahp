<?php

namespace App\Livewire\FinalRanking;

use App\Services\CriteriaMatrixService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\TableComponent;

class ComparisonMatrixTable extends TableComponent
{
    protected CriteriaMatrixService $matrixService;

    public function boot(): void
    {
        $this->matrixService = new CriteriaMatrixService();
    }

    public function table(Table $table): Table
    {
        $criterias = collect($this->matrixService->getCriterias());
        $comparisonMatrix = $this->matrixService->getComparisonMatrix();
        $columnTotals = $this->matrixService->getColumnTotals();

        $records = [];
        foreach ($criterias as $row) {
            $record = [
                'id' => $row['id'],
                'code' => 'C' . str_pad($row['id'], 2, '0', STR_PAD_LEFT),
                'name' => $row['name'],
            ];

            foreach ($criterias as $col) {
                $record['c_' . $col['id']] = $comparisonMatrix[$row['id']][$col['id']];
            }

            $records[$row['id']] = $record;
        }

        $totalRecord = [
            'id' => 'total',
            'code' => '',
            'name' => 'Total',
        ];
        foreach ($criterias as $col) {
            $totalRecord['c_' . $col['id']] = $columnTotals[$col['id']];
        }
        $records['total'] = $totalRecord;

        $columns = [
            TextColumn::make('code')
                ->label('Kode')
                ->weight('bold'),
            TextColumn::make('name')
                ->label('Nama')
                ->weight(fn($record) => $record['id'] === 'total' ? 'bold' : 'normal'),
        ];

        foreach ($criterias as $c) {
            $columns[] = TextColumn::make('c_' . $c['id'])
                ->label('C' . str_pad($c['id'], 2, '0', STR_PAD_LEFT))
                ->alignCenter()
                ->weight(fn($record) => $record['id'] === 'total' ? 'bold' : 'normal')
                ->color(fn($record) => $record['id'] === 'total' ? 'primary' : null)
                ->formatStateUsing(fn($state) => CriteriaMatrixService::formatValue($state));
        }

        return $table
            ->records(fn(): array => $records)
            ->columns($columns)
            ->paginated(false);
    }

    public function render()
    {
        return view('livewire.final-ranking.comparison-matrix-table');
    }
}
