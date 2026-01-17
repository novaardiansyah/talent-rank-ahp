<div>
  {{ $this->table }}

  <p style="margin-top: 1rem; font-size: 0.875rem; color: #9ca3af;">
    Berikut tabel ratio index berdasarkan ordo matriks.
  </p>

  <table style="width: 100%; margin-top: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem; border-collapse: collapse;">
    <thead>
      <tr style="border-bottom: 1px solid #374151;">
        <th style="padding: 0.5rem 0.75rem; text-align: left; font-weight: 500;">Ordo matriks</th>
        @for ($i = 1; $i <= 10; $i++)
          <th style="padding: 0.5rem 0.75rem; text-align: center;">{{ $i }}</th>
        @endfor
      </tr>
    </thead>
    <tbody>
      <tr style="border-bottom: 1px solid #374151;">
        <td style="padding: 0.5rem 0.75rem; font-weight: 500;">Ratio index</td>
        @foreach (\App\Services\CriteriaMatrixService::RI_TABLE as $ri)
          <td style="padding: 0.5rem 0.75rem; text-align: center;">{{ $ri }}</td>
        @endforeach
      </tr>
    </tbody>
  </table>

  <div style="font-size: 0.875rem; color: #9ca3af;">
    <p>Consistency Index: {{ \App\Services\CriteriaMatrixService::formatValue($this->getConsistencyIndex(), 3) }}</p>
    <p>Ratio Index: {{ \App\Services\CriteriaMatrixService::formatValue($this->getRatioIndex(), 2) }}</p>
    <p>
      Consistency Ratio: {{ \App\Services\CriteriaMatrixService::formatValue($this->getConsistencyRatio(), 2) }}
      @if ($this->getConsistencyRatio() <= 0.1)
        <span style="color: #16a34a;">(Konsisten)</span>
      @else
        <span style="color: #dc2626;">(Tidak Konsisten)</span>
      @endif
    </p>
  </div>
</div>
