@php
/*
 * Project Name: talent-rank-ahp
 * File: final-ranking-widget.blade.php
 * Created Date: Saturday January 17th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */
@endphp

<x-filament::widget>
    <x-filament::section heading="Hasil Akhir Perankingan">
        <livewire:final-ranking.final-result-table />
    </x-filament::section>
</x-filament::widget>
