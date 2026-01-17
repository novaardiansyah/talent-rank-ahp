@php
/*
 * Project Name: talent-rank-ahp
 * File: alternative-comparison-table.blade.php
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
  <p style="margin-bottom: 0.75rem;">
    Matriks Perbandingan Alternatif Berdasarkan <span style="font-weight: 600;">{{ $this->getCriteriaName() }}</span>
  </p>
  {{ $this->table }}
</div>
