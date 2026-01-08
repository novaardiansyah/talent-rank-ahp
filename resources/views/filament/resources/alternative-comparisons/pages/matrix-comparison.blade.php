<x-filament-panels::page>
  <x-filament::section>
    <x-slot name="heading">
      Ubah nilai bobot alternatif
    </x-slot>

    {{ $this->criterionForm }}

    <form wire:submit="updateComparison" style="margin-top: 1.4rem;">
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
