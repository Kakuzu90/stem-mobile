<x-modal title="New Student" classname="modal-dialog-centered modal-lg" target="add">
    <form action="{{ route('admin.students.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="row g-1 justify-content-center align-items-center">
                <div class="col-lg-4 col-12">
                    <label class="form-label">First Name</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i data-feather="user"></i>
                        </span>
                        <input 
                            type="text"
                            class="form-control" 
                            name="first_name" 
                            placeholder="Enter first name here" 
                            required />
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <label class="form-label">Middle Name</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i data-feather="user"></i>
                        </span>
                        <input 
                            type="text"
                            class="form-control" 
                            name="middle_name" 
                            placeholder="Enter middle name here" 
                            required />
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <label class="form-label">Last Name</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i data-feather="user"></i>
                        </span>
                        <input 
                            type="text"
                            class="form-control" 
                            name="last_name" 
                            placeholder="Enter last name here" 
                            required />
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <label class="form-label">Username</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">
                            <i data-feather="user"></i>
                        </span>
                        <input 
                            type="text"
                            class="form-control" 
                            name="username" 
                            placeholder="Enter username here" 
                            required />
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <label class="form-label">Password</label>
                    <div class="input-group input-group-merge form-password-toggle">
                        <span class="input-group-text">
                            <i data-feather="lock"></i>
                        </span>
                        <input 
                            type="password"
                            class="form-control" 
                            name="password" 
                            placeholder="Enter password here" 
                            required />
                        <span class="input-group-text cursor-pointer">
                            <i data-feather="eye"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group input-group-merge form-password-toggle">
                        <span class="input-group-text">
                            <i data-feather="lock"></i>
                        </span>
                        <input 
                            type="password"
                            class="form-control" 
                            name="password_confirmation" 
                            placeholder="Enter confirm password here" 
                            required />
                        <span class="input-group-text cursor-pointer">
                            <i data-feather="eye"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <label class="form-label">Age</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="age" 
                        placeholder="Enter age here" 
                        required />
                </div>
                <div class="col-lg-6 col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" placeholder="Enter address here" required></textarea>
                </div>
                <div class="col-lg-6 col-12">
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
                <div class="col-lg-6 col-12">
                    <label class="form-label">Subjects</label>
                    <select data-placeholder="Select a subject..." class="select2-icons form-select unique-subject" name="subjects[]" multiple required></select>
                </div>
                <div class="col-lg-6 col-12">
                    <label class="form-label">Date Valid</label>
                    <input 
                        type="text" 
                        class="form-control flatpickr-human-friendly" 
                        name="date_valid" 
                        data-date-format="YYYY-MM-DD"
                        placeholder="Select a date here" 
                        readonly
                        required />
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