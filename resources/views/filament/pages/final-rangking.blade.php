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

  <x-filament::section collapsible heading="Matriks Perbandingan Alternatif">
    <div>
      <p class="text-sm text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem;">
        Selanjutnya setelah menemukan bobot prioritas kriteria, menetapkan nilai skala perbandingan alternatif berdasarkan masing-masing kriteria. Nilai skala sesuai dengan kebijakan perusahaan. Langkah selanjutnya membuat matriks perbandingan alternatif berdasarkan kriteria. Setelah terbentuk matriks perbandingan alternatif berdasarkan kriteria maka dicari bobot prioritas untuk perbandingan alternatif terhadap masing,masing kriteria. Buat kriteria selanjutnya dengan cara yang sama.
      </p>

      @php
        $criterias = \App\Models\Criteria::orderBy('id')->get();
      @endphp

      @foreach ($criterias as $index => $criteria)
        <div style="{{ $index > 0 ? 'margin-top: 2rem;' : '' }}">
          <livewire:final-ranking.alternative-comparison-table :criteriaId="$criteria->id" :key="'alt-comp-' . $criteria->id" />
          <div style="margin-top: 1.5rem;">
            <livewire:final-ranking.alternative-priority-table :criteriaId="$criteria->id" :key="'alt-prio-' . $criteria->id" />
          </div>
        </div>
        <hr style="margin-top: 1rem;">
      @endforeach
    </div>
  </x-filament::section>
</x-filament-panels::page>
