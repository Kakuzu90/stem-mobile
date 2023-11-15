<x-modal title="Upload Teachers" classname="modal-dialog-centered" target="upload">
    <form action="{{ route('admin.teachers.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-1">
                <input 
                    type="file"
                    class="form-control" 
                    name="file" 
                    placeholder="Select a file" 
                    required />
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-relief-primary">
                <i data-feather="database"></i>
                Upload File
            </button>
        </div>
    </form>
</x-modal>