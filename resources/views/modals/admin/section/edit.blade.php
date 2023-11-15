<x-modal title="New Grade Level" classname="modal-dialog-centered" target="edit">
    <form method="POST">
        @csrf
        @method('PUT')

        <div id="spinner" style="height: 150px;" class="d-flex justify-content-center align-items-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div id="form-container" class="d-none">
            <div class="modal-body">
                <div class="mb-1">
                    <label class="form-label">Section Name</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i data-feather="briefcase"></i>
                        </span>
                        <input 
                            type="text"
                            class="form-control" 
                            name="name" 
                            placeholder="Enter section name here" 
                            required />
                    </div>
                </div>
                <div class="mb-1">
                    <label class="form-label">Grade Level</label>
                    <select data-placeholder="Select a grade level..." class="select2-icons form-select" name="grade" required>
                        @foreach ($grades as $grade)
                            <option value="{{ $grade->id }}" data-icon="bar-chart">
                                {{ $grade->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-relief-success">
                    <i data-feather="database"></i>
                    Submit Changes
                </button>
            </div>
        </div>
    </form>
</x-modal>