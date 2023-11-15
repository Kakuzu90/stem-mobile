<x-modal title="Add Subjects to Classroom" classname="modal-dialog-centered" target="subject">
    <form method="POST">
        @csrf
        <div id="spinner" style="height: 150px;" class="d-flex justify-content-center align-items-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div id="form-container" class="d-none">
            <div class="modal-body">
                <div class="mb-1">
                    <label class="form-label">Subjects</label>
                    <select data-bs-placeholder="Select a state..." class="select2-icons form-select" name="subjects[]" required multiple="multiple">
                        @foreach ($data['subjects'] as $subject)
                            <option value="{{ $subject->id }}" data-icon="layers">
                                {{ $subject->name }}
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
        </div>
    </form>
</x-modal>