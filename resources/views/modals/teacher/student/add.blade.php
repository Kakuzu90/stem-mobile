<x-modal title="Add New Student" classname="modal-dialog-centered" target="add">
  <form action="{{ route('teacher.students.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="mb-1">
            <label class="form-label">Student</label>
            <select class="select2-icons form-select" id="select2-ajax" name="student" required></select>
        </div>
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
          <button type="submit" class="btn btn-relief-primary">
              <i data-feather="database"></i>
              Submit
          </button>
      </div>
  </form>
</x-modal>