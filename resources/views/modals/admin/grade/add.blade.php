<x-modal title="New Grade Level" classname="modal-dialog-centered" target="add">
    <form action="{{ route('admin.grade-level.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-1">
                <label class="form-label">Grade Level</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i data-feather="bar-chart"></i>
                    </span>
                    <input 
                        type="text"
                        class="form-control" 
                        name="name" 
                        placeholder="Enter grade level here" 
                        required />
                </div>
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