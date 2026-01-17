<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class FinalRankingWidget extends Widget
{
  protected string $view = 'filament.widgets.final-ranking-widget';

  protected int|string|array $columnSpan = 'full';

  protected static ?int $sort = 2;
}
