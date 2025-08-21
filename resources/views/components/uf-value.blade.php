<div class="uf-value d-inline-flex align-items-center">
    <i class="fas fa-coins text-warning me-2"></i>
    <span class="fw-bold text-white">UF:</span>
    @if($value)
        <span class="ms-2 badge bg-primary fs-6">
            ${{ number_format((float)$value, 2, ',', '.') }}
        </span>
    @else
        <span class="ms-2 badge bg-secondary fs-6">
            No disponible
        </span>
    @endif
</div>