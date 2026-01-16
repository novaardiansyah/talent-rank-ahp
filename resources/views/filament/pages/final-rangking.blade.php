<x-filament-panels::page>
  <x-filament::section collapsible heading="Mengukur Konsistensi Kriteria">
    <x-filament::section collapsible heading="Matriks Perbandingan Kriteria">
      <div>
        <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem;">
          Pertama-tama menyusun hirarki dimana diawali dengan tujuan, kriteria dan alternatif yang akan dinilai.
          Selanjutnya menetapkan perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik.
          Nilai diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi dengan bilangan (1)
          sedangkan isi nilai perbandingan antara (1) sampai dengan (9) kebalikannya, kemudian dijumlahkan perkolom.
          Data matrik tersebut seperti terlihat pada tabel berikut.
        </p>

        {{ $this->table }}
      </div>
    </x-filament::section>
  </x-filament::section>
</x-filament-panels::page>
