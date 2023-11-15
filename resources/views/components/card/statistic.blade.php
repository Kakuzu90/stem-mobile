<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="avatar avatar-lg me-1 {{ $color }}">
                <div class="avatar-content">
                    <i data-feather="{{ $icon }}"></i>
                </div>
            </div>
            <div class="card-info">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 text-dark">{{ $count }}</h4>
                </div>
                <small class="text-truncate">Total {{ $title }}</small>
            </div>
        </div>
    </div>
</div>