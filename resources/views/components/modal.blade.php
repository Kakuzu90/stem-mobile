<div class="modal fade" id="{{ $target }}" tabindex="-1">
    <div class="modal-dialog {{ $classname }}">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">{{ $title }}</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>