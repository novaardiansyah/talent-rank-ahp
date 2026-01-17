<x-filament-panels::page>
  <x-filament::section collapsible collapsed heading="Mengukur Konsistensi Kriteria">
    <x-filament::section collapsible heading="Matriks Perbandingan Kriteria" style="margin-bottom: 2rem;">
      <div>
        <p class="text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem; font-size: .90rem;">
          Langkah awal dalam metode AHP adalah membangun struktur hierarki yang terdiri dari tujuan, kriteria penilaian, dan alternatif kandidat. Tahap berikutnya melakukan evaluasi perbandingan berpasangan antar kriteria dalam format matriks. Elemen diagonal matriks bernilai 1 karena membandingkan kriteria dengan dirinya sendiri, sementara nilai perbandingan lainnya berkisar antara 1 hingga 9 atau kebalikannya. Total setiap kolom kemudian dihitung untuk proses normalisasi selanjutnya.
        </p>

        <livewire:final-ranking.comparison-matrix-table />
      </div>
    </x-filament::section>

    <x-filament::section collapsible heading="Matriks Bobot Prioritas Kriteria">
      <div>
        <p class="text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem; font-size: .90rem;">
          Dari matriks perbandingan yang telah disusun, selanjutnya dilakukan perhitungan bobot prioritas masing-masing kriteria. Proses normalisasi dilakukan dengan membagi setiap elemen matriks dengan total kolomnya, lalu menjumlahkan nilai per baris dan membaginya dengan jumlah kriteria untuk memperoleh bobot prioritas akhir.
        </p>

        <livewire:final-ranking.priority-matrix-table />
      </div>
    </x-filament::section>

    <x-filament::section collapsible heading="Matriks Konsistensi Kriteria" style="margin-top: 2rem;">
      <div>
        <p class="text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem; font-size: .90rem;">
          Validasi konsistensi matriks dilakukan dengan mengalikan setiap kolom matriks perbandingan dengan bobot prioritas kriteria yang bersesuaian. Hasil perkalian dijumlahkan per baris, kemudian dibagi dengan bobot prioritas masing-masing untuk mendapatkan nilai konsistensi yang akan digunakan dalam menghitung Consistency Ratio (CR).
        </p>

        <livewire:final-ranking.consistency-matrix-table />
      </div>
    </x-filament::section>
  </x-filament::section>

  <x-filament::section collapsible collapsed heading="Matriks Perbandingan Alternatif">
    <div>
      <p class="text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem; font-size: .90rem;">
        Setelah bobot kriteria diperoleh, tahap selanjutnya adalah mengevaluasi setiap alternatif kandidat berdasarkan masing-masing kriteria menggunakan skala penilaian yang telah ditetapkan. Matriks perbandingan alternatif dibentuk untuk setiap kriteria, kemudian dihitung bobot prioritas alternatif terhadap kriteria tersebut dengan metode yang sama seperti sebelumnya.
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

  <x-filament::section collapsible heading="Hasil Akhir">
    <div>
      <p class="text-gray-600 dark:text-gray-400" style="margin-bottom: 1rem; font-size: .90rem;">
        Tahap akhir perhitungan AHP adalah mengintegrasikan bobot kriteria dengan bobot alternatif. Setiap bobot alternatif dikalikan dengan bobot kriteria yang bersesuaian, kemudian hasil perkalian dijumlahkan untuk mendapatkan skor prioritas global. Alternatif dengan skor tertinggi merupakan kandidat terbaik berdasarkan analisis AHP.
      </p>

      <livewire:final-ranking.final-result-table />
    </div>
  </x-filament::section>
</x-filament-panels::page>
