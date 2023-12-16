<x-modal title="New Announcement" classname="modal-dialog-centered" target="edit">
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
              <div class="mb-1">
                <label class="form-label">Date Open</label>
                <input 
                    type="text" 
                    class="form-control flatpickr-human-friendly" 
                    name="date_open"
                    data-date-format="YYYY-MM-DD"
                    placeholder="Select a date here" 
                    readonly
                    required />
                </div>
            <div class="mb-1">
                <label class="form-label">Date Closed</label>
                <input 
                    type="text" 
                    class="form-control flatpickr-human-friendly" 
                    name="date_closed"
                    data-date-format="YYYY-MM-DD"
                    placeholder="Select a date here" 
                    readonly
                    required />
            </div>
              <div class="d-flex flex-column">
                  <label class="form-check-label mb-50" for="publish1">Publish</label>
                  <div class="form-check form-switch form-check-success">
                      <input type="checkbox" class="form-check-input" id="publish1" name="publish" />
                      <label class="form-check-label" for="publish1">
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
      </div>
  </form>
</x-modal>