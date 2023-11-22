<x-modal title="New Activity" classname="modal-dialog-centered" target="add">
  <form action="{{ route('teacher.assignments.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
          <div class="mb-1">
              <label class="form-label">Title</label>
              <div class="input-group input-group-merge">
                  <span class="input-group-text">
                      <i data-feather="book"></i>
                  </span>
                  <input 
                      type="text"
                      class="form-control" 
                      name="title" 
                      placeholder="Enter title here" 
                      required />
              </div>
          </div>
          <div class="mb-1">
              <label class="form-label">Time</label>
              <div class="input-group input-group-merge">
                  <span class="input-group-text">
                      <i data-feather="clock"></i>
                  </span>
                  <input 
                      type="text"
                      class="form-control time" 
                      name="timer" 
                      placeholder="hh:mm:ss" 
                      required />
              </div>
          </div>
          <div class="mb-1">
              <label class="form-label">Classroom</label>
              <select data-placeholder="Select a classroom..." class="select2-icons form-select" name="classroom" required>
                      <option value="">Select a classroom...</option>
                  @foreach ($classrooms as $classroom)
                      <option value="{{ $classroom->classroom->id }}" data-icon="columns">
                          {{ $classroom->classroom->title() }}
                      </option>
                  @endforeach
              </select>
          </div>
          <div class="mb-1">
              <label class="form-label">Subjects</label>
              <select data-placeholder="Select a subject..." class="select2-icons form-select subjects" name="subjects[]" multiple required></select>
          </div>
          <div class="d-flex flex-column">
              <label class="form-check-label mb-50" for="publish">Publish</label>
              <div class="form-check form-switch form-check-success">
                  <input type="checkbox" class="form-check-input" id="publish" name="publish" />
                  <label class="form-check-label" for="publish">
                      <span class="switch-icon-left"><i data-feather="check"></i></span>
                      <span class="switch-icon-right"><i data-feather="x"></i></span>
                  </label>
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