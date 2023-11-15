<x-modal title="Upload Students" classname="modal-dialog-centered" target="upload">
    <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
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
            <div class="mb-1">
                <label class="form-label">Classroom</label>
                <select data-placeholder="Select a classroom..." class="select2-icons form-select unique-classroom" name="classroom" required>
                    <option value="">Select a classroom...</option>
                    @foreach ($data['classrooms'] as $classroom)
                        <option value="{{ $classroom->id }}" data-icon="columns">
                            {{ $classroom->title() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-1">
                <label class="form-label">Subjects</label>
                <select data-placeholder="Select a subject..." class="select2-icons form-select unique-subject" name="subjects[]" multiple required></select>
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