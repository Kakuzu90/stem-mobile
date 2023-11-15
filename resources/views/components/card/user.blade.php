<div class="card">
    <div class="row">
        <div class="col-6">
            <div class="card-body">
                <h3 class="text-nowrap">
                    {{ $user }}
                </h3>
                <div class="avatar avatar-xl bg-light-primary p-50 mb-1">
                    <div class="avatar-content">
                        <i data-feather="user" class="fs-1"></i>
                    </div>
                </div>
                <div class="d-flex align-items-end flex-wrap">
                    <h4 class="mb-0 me-2 fs-1">{{ $count }}</h4>
                    <small class="text-truncate">Total {{ $user }}</small>
                </div>
            </div>
        </div>
        <div class="col-6 text-end d-flex align-items-center justify-content-center">
            <div class="card-body pb-0 pt-3 position-absolute bottom-0">
                @if ($type === 1)
                    <img src="{{ asset('images/male.png') }}" alt="Male" width="141" />
                @else
                    <img src="{{ asset('images/female.png') }}" alt="Female" width="121" />
                @endif
                
            </div>
        </div>
    </div>
</div>