<x-modal title="New School Year" classname="modal-dialog-centered" target="edit">
  <form method="POST" enctype="multipart/form-data">
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
                          <i data-feather="file-text"></i>
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
                  <input 
                      type="file"
                      class="form-control" 
                      name="module" 
                      placeholder="Select a file" 
                       />
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
              <button type="submit" class="btn btn-relief-success">
                  <i data-feather="database"></i>
                  Submit Changes
              </button>
          </div>
      </div>
  </form>
</x-modal>