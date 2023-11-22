<x-modal title="New Announcement" classname="modal-dialog-centered" target="add">
  <form action="{{ route('teacher.announcements.store') }}" method="POST">
      @csrf
      <div class="modal-body">
          <div class="mb-1">
              <label class="form-label">Title</label>
              <div class="input-group input-group-merge">
                  <span class="input-group-text">
                      <i data-feather="bookmark"></i>
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
              <label class="form-label">Context</label>
              <textarea name="context" class="form-control" placeholder="Enter context here" required></textarea>
          </div>
          <div class="mb-1">
              <label class="form-label">Classroom</label>
              <select data-placeholder="Select a classroom..." class="select2-icons form-select" name="classrooms[]" multiple required>
                  @foreach ($classrooms as $classroom)
                      <option value="{{ $classroom->classroom_id }}" data-icon="user">
                          {{ $classroom->classroom->title() }}
                      </option>
                  @endforeach
              </select>
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