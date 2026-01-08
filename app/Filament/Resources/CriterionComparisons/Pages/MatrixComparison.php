<?php

namespace App\Filament\Resources\CriterionComparisons\Pages;

use App\Filament\Resources\CriterionComparisons\CriterionComparisonResource;
use App\Models\Criteria;
use App\Models\CriterionComparison;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class MatrixComparison extends Page implements HasTable, HasForms
{
  use InteractsWithTable;
  use InteractsWithForms;

  protected static string $resource = CriterionComparisonResource::class;

  protected static ?string $title = 'Nilai Bobot Kriteria';

  protected string $view = 'filament.resources.criterion-comparisons.pages.matrix-comparison';

  public ?array $data = [];

  public function mount(): void
  {
    $this->form->fill();
  }

  public function form(Schema $schema): Schema
  {
    $criteriaOptions = Criteria::all()->mapWithKeys(function ($criteria) {
      return [$criteria->id => $criteria->name . ' - ' . $criteria->description];
    })->toArray();

    $comparisonOptions = [
      '1' => '1 - Sama penting',
      '2' => '2 - Mendekati sedikit lebih penting dari',
      '3' => '3 - Sedikit lebih penting dari',
      '4' => '4 - Mendekati lebih penting dari',
      '5' => '5 - Lebih penting dari',
      '6' => '6 - Mendekati sangat lebih penting dari',
      '7' => '7 - Sangat lebih penting dari',
      '8' => '8 - Mendekati mutlak lebih penting dari',
      '9' => '9 - Mutlak lebih penting dari',
    ];

    return $schema
      ->schema([
        Select::make('criterion_id_1')
          ->label('Kriteria 1')
          ->options($criteriaOptions)
          ->searchable()
          ->required()
          ->native(false),
        Select::make('value')
          ->label('Nilai Perbandingan')
          ->options($comparisonOptions)
          ->required()
          ->native(false)
          ->default('1'),
        Select::make('criterion_id_2')
          ->label('Kriteria 2')
          ->options($criteriaOptions)
          ->searchable()
          ->required()
          ->native(false),
      ])
      ->columns(3)
      ->statePath('data');
  }

  public function updateComparison(): void
  {
    $data = $this->form->getState();
    $value = (float) $data['value'];

    if (($data['criterion_id_1'] === $data['criterion_id_2']) && $value !== 1) {
      Notification::make()
        ->title('Gagal simpan perubahan')
        ->body('Kriteria yang sama harus memiliki nilai perbandingan (1 - Sama penting)')
        ->danger()
        ->send();

      return;
    }

    $inverseValue = 1 / $value;

    CriterionComparison::updateOrCreate(
      [
        'criterion_id_1' => $data['criterion_id_1'],
        'criterion_id_2' => $data['criterion_id_2'],
      ],
      ['value' => $value]
    );

    CriterionComparison::updateOrCreate(
      [
        'criterion_id_1' => $data['criterion_id_2'],
        'criterion_id_2' => $data['criterion_id_1'],
      ],
      ['value' => $inverseValue]
    );

    Notification::make()
      ->title('Nilai bobot kriteria berhasil diubah!')
      ->success()
      ->send();

    $this->resetTable();
  }

  public function table(Table $table): Table
  {
    $criterias = Criteria::all();
    $comparisons = CriterionComparison::all();

    $matrix = [];
    foreach ($comparisons as $comp) {
      $matrix[$comp->criterion_id_1][$comp->criterion_id_2] = $comp->value;
    }

    $records = [];
    foreach ($criterias as $row) {
      $record = [
        'id' => $row->id,
        'name' => $row->name,
      ];
      foreach ($criterias as $col) {
        $record['c_' . $col->id] = $matrix[$row->id][$col->id] ?? 1;
      }
      $records[$row->id] = $record;
    }

    $columns = [
      TextColumn::make('name')
        ->label('Kriteria')
        ->weight('bold'),
    ];

    foreach ($criterias as $c) {
      $columns[] = TextColumn::make('c_' . $c->id)
        ->label($c->name)
        ->alignCenter()
        ->formatStateUsing(fn($state) => rtrim(rtrim(number_format($state, 2, '.', ''), '0'), '.'));
    }

    return $table
      ->records(fn(): array => $records)
      ->columns($columns)
      ->paginated(false);
  }
}
