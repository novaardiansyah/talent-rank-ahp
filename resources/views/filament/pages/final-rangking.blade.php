<x-filament-panels::page>
  <x-filament::section collapsible heading="Mengukur Konsistensi Kriteria">
    <x-filament::section collapsible heading="Matriks Perbandingan Kriteria" style="margin-bottom: 2rem;">
      <div>
        <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem;">
          Pertama-tama menyusun hirarki dimana diawali dengan tujuan, kriteria dan alternatif yang akan dinilai. Selanjutnya menetapkan perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik. Nilai diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi dengan bilangan (1) sedangkan isi nilai perbandingan antara (1) sampai dengan (9) kebalikannya, kemudian dijumlahkan perkolom. Data matrik tersebut seperti terlihat pada tabel berikut.
        </p>

        <livewire:final-ranking.comparison-matrix-table />
      </div>
    </x-filament::section>

    <x-filament::section collapsible heading="Matriks Bobot Prioritas Kriteria">
      <div>
        <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem;">
          Setelah terbentuk matrik perbandingan maka dilihat bobot prioritas untuk perbandingan kriteria. Dengan cara membagi isi matriks perbandingan dengan jumlah kolom yang bersesuaian, kemudian menjumlahkan perbaris setelah itu hasil penjumlahan dibagi dengan banyaknya kriteria sehingga ditemukan bobot prioritas seperti terlihat pada tabel berikut.
        </p>

        <livewire:final-ranking.priority-matrix-table />
      </div>
    </x-filament::section>

    <x-filament::section collapsible heading="Matriks Konsistensi Kriteria" style="margin-top: 2rem;">
      <div>
        <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem;">
          Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian seperti terlihat pada tabel berikut.
        </p>

        <livewire:final-ranking.consistency-matrix-table />
      </div>
    </x-filament::section>
  </x-filament::section>
</x-filament-panels::page>
