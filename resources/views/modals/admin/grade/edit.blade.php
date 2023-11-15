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
                <button type="submit" class="btn btn-relief-success">
                    <i data-feather="database"></i>
                    Submit Changes
                </button>
            </div>
        </div>
    </form>
</x-modal>