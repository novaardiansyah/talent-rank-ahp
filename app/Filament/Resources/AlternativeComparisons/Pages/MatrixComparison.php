<?php

/*
 * Project Name: talent-rank-ahp
 * File: MatrixComparison.php
 * Created Date: Thursday January 8th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Resources\AlternativeComparisons\Pages;

use App\Filament\Resources\AlternativeComparisons\AlternativeComparisonResource;
use App\Models\Alternative;
use App\Models\AlternativeComparison;
use App\Models\Criteria;
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

  protected static string $resource = AlternativeComparisonResource::class;

  protected static ?string $title = 'Nilai Bobot Alternatif';

  protected string $view = 'filament.resources.alternative-comparisons.pages.matrix-comparison';

  public ?array $data = [];

  public ?string $selectedCriterionId = null;

  public function mount(): void
  {
    $this->selectedCriterionId = Criteria::first()?->id;
    $this->form->fill();
  }

  public function criterionForm(Schema $schema): Schema
  {
    $criteriaOptions = Criteria::all()->mapWithKeys(function ($criteria) {
      return [$criteria->id => '[' . $criteria->name . '] ' . $criteria->description];
    })->toArray();

    return $schema
      ->schema([
        Select::make('selectedCriterionId')
          ->label('Pilih Kriteria')
          ->options($criteriaOptions)
          ->searchable()
          ->required()
          ->native(false)
          ->live(),
      ])->columns(3);
  }

  public function form(Schema $schema): Schema
  {
    $alternativeOptions = Alternative::all()->mapWithKeys(function ($alternative) {
      return [$alternative->id => '[' . $alternative->name . '] ' . $alternative->description];
    })->toArray();

    $comparisonOptions = [
      '1' => '1 - Sama penting dengan',
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
        Select::make('alternative_id_1')
          ->label('Alternatif 1')
          ->options($alternativeOptions)
          ->searchable()
          ->required()
          ->native(false),
        Select::make('value')
          ->label('Nilai Perbandingan')
          ->options($comparisonOptions)
          ->required()
          ->native(false)
          ->default('1'),
        Select::make('alternative_id_2')
          ->label('Alternatif 2')
          ->options($alternativeOptions)
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

    if (($data['alternative_id_1'] === $data['alternative_id_2']) && $value !== 1) {
      Notification::make()
        ->title('Gagal simpan perubahan')
        ->body('Alternatif yang sama harus memiliki nilai perbandingan (1 - Sama penting)')
        ->danger()
        ->send();

      return;
    }

    $inverseValue = 1 / $value;

    AlternativeComparison::updateOrCreate(
      [
        'criterion_id' => $this->selectedCriterionId,
        'alternative_id_1' => $data['alternative_id_1'],
        'alternative_id_2' => $data['alternative_id_2'],
      ],
      ['value' => $value]
    );

    AlternativeComparison::updateOrCreate(
      [
        'criterion_id' => $this->selectedCriterionId,
        'alternative_id_1' => $data['alternative_id_2'],
        'alternative_id_2' => $data['alternative_id_1'],
      ],
      ['value' => $inverseValue]
    );

    Notification::make()
      ->title('Nilai bobot alternatif berhasil diubah!')
      ->success()
      ->send();

    $this->resetTable();
  }

  public function updatedSelectedCriterionId(): void
  {
    $this->resetTable();
  }

  public function table(Table $table): Table
  {
    $alternatives = Alternative::all();
    $comparisons = AlternativeComparison::where('criterion_id', $this->selectedCriterionId)->get();

    $matrix = [];
    foreach ($comparisons as $comp) {
      $matrix[$comp->alternative_id_1][$comp->alternative_id_2] = $comp->value;
    }

    $records = [];
    foreach ($alternatives as $row) {
      $record = [
        'id' => $row->id,
        'name' => $row->name,
      ];
      foreach ($alternatives as $col) {
        $record['a_' . $col->id] = $matrix[$row->id][$col->id] ?? 1;
      }
      $records[$row->id] = $record;
    }

    $columns = [
      TextColumn::make('name')
        ->label('Kode')
        ->weight('bold'),
    ];

    foreach ($alternatives as $a) {
      $columns[] = TextColumn::make('a_' . $a->id)
        ->label($a->name)
        ->alignCenter()
        ->formatStateUsing(fn($state) => rtrim(rtrim(number_format($state, 3, '.', ''), '0'), '.'));
    }

    return $table
      ->records(fn(): array => $records)
      ->columns($columns)
      ->paginated(false);
  }
}
