<x-filament-panels::page>
  <x-filament::section>
    <x-slot name="heading">
      Ubah Nilai Perbandingan
    </x-slot>

    <form wire:submit="updateComparison">
      {{ $this->form }}

      <x-filament::button type="submit" icon="heroicon-o-pencil-square" style="margin-top: 1rem;">
        Ubah
      </x-filament::button>
    </form>
  </x-filament::section>

  <div class="mt-6">
    {{ $this->table }}
  </div>
</x-filament-panels::page>
