<?php

namespace App\Filament\Pages;

use App\Models\Criteria;
use App\Models\CriterionComparison;
use BackedEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use UnitEnum;

class FinalRangking extends Page implements HasTable, HasForms
{
  use InteractsWithTable;
  use InteractsWithForms;

  protected string $view = 'filament.pages.final-rangking';
  protected static ?string $navigationLabel = 'Perhitungan';
  protected static ?string $title = 'Perhitungan';
  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;
  protected static string|UnitEnum|null $navigationGroup = 'Perhitungan Final';
  protected static ?string $slug = 'report/final-rangking';

  public function getBreadcrumbs(): array
  {
    return [
      '/report/final-rangking' => 'Perhitungan Final',
      '#' => 'Perhitungan',
    ];
  }

  public function table(Table $table): Table
  {
    $criterias = Criteria::orderBy('id')->get();
    $comparisons = CriterionComparison::all();

    $matrix = [];
    foreach ($comparisons as $comp) {
      $matrix[$comp->criterion_id_1][$comp->criterion_id_2] = $comp->value;
    }

    $records = [];
    $columnTotals = [];

    foreach ($criterias as $col) {
      $columnTotals[$col->id] = 0;
    }

    foreach ($criterias as $row) {
      $record = [
        'id' => $row->id,
        'code' => 'C' . str_pad($row->id, 2, '0', STR_PAD_LEFT),
        'name' => $row->name,
      ];

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

        $record['c_' . $col->id] = $value;
        $columnTotals[$col->id] += $value;
      }

      $records[$row->id] = $record;
    }

    $totalRecord = [
      'id' => 'total',
      'code' => '',
      'name' => 'Total',
    ];
    foreach ($criterias as $col) {
      $totalRecord['c_' . $col->id] = $columnTotals[$col->id];
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
      $columns[] = TextColumn::make('c_' . $c->id)
        ->label('C' . str_pad($c->id, 2, '0', STR_PAD_LEFT))
        ->alignCenter()
        ->weight(fn($record) => $record['id'] === 'total' ? 'bold' : 'normal')
        ->color(fn($record) => $record['id'] === 'total' ? 'primary' : null)
        ->formatStateUsing(function ($state) {
          if ($state == (int) $state) {
            return (string) (int) $state;
          }
          return rtrim(rtrim(number_format($state, 4, '.', ''), '0'), '.');
        });
    }

    return $table
      ->records(fn(): array => $records)
      ->columns($columns)
      ->paginated(false);
  }
}
