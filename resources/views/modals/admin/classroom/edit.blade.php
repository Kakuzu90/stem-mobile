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
                    <label class="form-label">Teacher</label>
                    <select data-placeholder="Select a teacher..." class="select2-icons form-select" name="teacher" required>
                        @foreach ($data['teachers'] as $teacher)
                            <option value="{{ $teacher->id }}" data-icon="user">
                                {{ $teacher->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-1">
                    <label class="form-label">Section</label>
                    <select data-placeholder="Select a section..." class="select2-icons form-select" name="section" required>
                        @foreach ($data['sections'] as $section)
                            <option value="{{ $section->id }}" data-icon="briefcase">
                                {{ $section->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-1">
                    <label class="form-label">School Year</label>
                    <select data-placeholder="Select a school year..." class="select2-icons form-select" name="year" required>
                        @foreach ($data['years'] as $year)
                            <option value="{{ $year->id }}" data-icon="calendar">
                                {{ $year->name }}
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