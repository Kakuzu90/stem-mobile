<x-modal title="New Section" classname="modal-dialog-centered" target="add">
    <form action="{{ route('admin.sections.store') }}" method="POST">
        @csrf
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
            <button type="submit" class="btn btn-relief-primary">
                <i data-feather="database"></i>
                Submit
            </button>
        </div>
    </form>
</x-modal>