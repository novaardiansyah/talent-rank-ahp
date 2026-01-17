<div>
  <p style="margin-bottom: 0.75rem;">
    Matrik bobot prioritas alternatif berdasarkan <span style="font-weight: 600;">{{ $this->getCriteriaName() }}</span>
  </p>
  {{ $this->table }}

  <div style="font-size: 0.875rem; color: #9ca3af; margin-top: 1rem;">
    <p>Consistency Index: {{ \App\Services\CriteriaMatrixService::formatValue($this->getConsistencyIndex(), 2) }}</p>
    <p>Ratio Index: {{ \App\Services\CriteriaMatrixService::formatValue($this->getRatioIndex(), 2) }}</p>
    <p>
      Consistency Ratio: {{ \App\Services\CriteriaMatrixService::formatValue($this->getConsistencyRatio(), 3) }}
      @if ($this->getConsistencyRatio() <= 0.1)
        <span style="color: #16a34a;">(Konsisten)</span>
      @else
        <span style="color: #dc2626;">(Tidak Konsisten)</span>
      @endif
    </p>
  </div>
</div>
