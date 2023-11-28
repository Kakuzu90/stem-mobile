<x-modal title="Add New Student" classname="modal-dialog-centered" target="edit">
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
              <label class="form-label">Classroom</label>
              <select data-placeholder="Select a classroom..." class="select2-icons form-select" name="classroom" required>
                      <option value="">Select a classroom...</option>
                  @foreach ($classrooms as $classroom)
                      <option value="{{ $classroom->classroom_id }}" data-icon="columns">
                          {{ $classroom->classroom->title() }}
                      </option>
                  @endforeach
              </select>
          </div>
          <div class="mb-1">
              <label class="form-label">Subjects</label>
              <select data-placeholder="Select a subject..." class="select2-icons form-select subjects" name="subjects[]" multiple required></select>
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