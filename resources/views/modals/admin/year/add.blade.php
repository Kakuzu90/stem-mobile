<x-modal title="New School Year" classname="modal-dialog-centered" target="add">
    <form action="{{ route('admin.school-year.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-1">
                <label class="form-label">School Year</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i data-feather="calendar"></i>
                    </span>
                    <input 
                        type="text"
                        class="form-control" 
                        name="name" 
                        placeholder="Enter school year here" 
                        required />
                </div>
            </div>
            <div class="mb-1">
                <label class="form-label">Date From</label>
                <input 
                    type="text" 
                    class="form-control flatpickr-human-friendly" 
                    name="date_from"
                    data-date-format="YYYY-MM-DD"
                    placeholder="Select a date here" 
                    readonly
                    required />
            </div>
            <div class="mb-1">
                <label class="form-label">Date To</label>
                <input 
                    type="text" 
                    class="form-control flatpickr-human-friendly" 
                    name="date_to" 
                    data-date-format="YYYY-MM-DD"
                    placeholder="Select a date here" 
                    readonly
                    required />
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