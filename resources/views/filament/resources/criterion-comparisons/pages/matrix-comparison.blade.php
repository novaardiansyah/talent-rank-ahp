@php
/*
 * Project Name: talent-rank-ahp
 * File: matrix-comparison.blade.php
 * Created Date: Thursday January 8th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */
@endphp

<x-filament-panels::page>
  <x-filament::section>
    <x-slot name="heading">
      Ubah nilai bobot kriteria
    </x-slot>

    <form wire:submit="updateComparison">
      {{ $this->form }}

      <x-filament::button type="submit" icon="heroicon-o-pencil-square" style="margin-top: 1.2rem;">
        Ubah
      </x-filament::button>
    </form>
  </x-filament::section>

  <div class="mt-6">
    {{ $this->table }}
  </div>
</x-filament-panels::page>
