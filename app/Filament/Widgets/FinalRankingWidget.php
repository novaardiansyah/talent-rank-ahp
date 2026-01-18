<?php

/*
 * Project Name: talent-rank-ahp
 * File: FinalRankingWidget.php
 * Created Date: Saturday January 17th 2026
 *
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 *
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class FinalRankingWidget extends Widget
{
  protected string $view = 'filament.widgets.final-ranking-widget';

  protected int|string|array $columnSpan = 'full';

  protected static ?int $sort = 2;

  public static function canView(): bool
  {
    return Auth::user()?->can('View:FinalRankingWidget') ?? false;
  }
}
