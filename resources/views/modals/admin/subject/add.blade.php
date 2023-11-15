<x-modal title="New Subject" classname="modal-dialog-centered" target="add">
    <form action="{{ route('admin.subjects.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-1">
                <label class="form-label">Subject Name</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i data-feather="layers"></i>
                    </span>
                    <input 
                        type="text"
                        class="form-control" 
                        name="name" 
                        placeholder="Enter subject name here" 
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