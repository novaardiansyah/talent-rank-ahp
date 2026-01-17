@php
/*
 * Project Name: talent-rank-ahp
 * File: final-result-table.blade.php
 * Created Date: Saturday January 17th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */
@endphp

<div>
  {{ $this->table }}

  <p style="margin-top: 1rem; font-size: 0.875rem; color: #9ca3af;">
    {!! $this->getRankingDescription() !!}
  </p>
</div>
