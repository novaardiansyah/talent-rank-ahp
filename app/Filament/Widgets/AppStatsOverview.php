<?php

/*
 * Project Name: talent-rank-ahp
 * File: AppStatsOverview.php
 * Created Date: Saturday January 17th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Widgets;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppStatsOverview extends BaseWidget
{
  protected static ?int $sort = 1;

  protected int|string|array $columnSpan = 2;

  protected function getStats(): array
  {
    return [
      Stat::make('Total Kriteria', Criteria::count())
        ->description('Jumlah kriteria penilaian')
        ->color('success'),
      Stat::make('Total Alternatif', Alternative::count())
        ->description('Jumlah kandidat talent')
        ->color('info'),
      Stat::make('Total Pengguna', User::count())
        ->description('Jumlah pengguna terdaftar')
        ->color('danger'),
    ];
  }
}
