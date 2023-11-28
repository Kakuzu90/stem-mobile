@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->guard('teacher')->user()->fullname }} to E-Learning Management System | E-LMS
  @else
  {{ $user->fullname }} Profile | E-LMS
  @endif
@endsection

@section('body')
  <div class="content-body">
    <div class="row">
      <div class="col-lg-4">
        <div class="card">
          <img src="{{ $user->profile }}" class="card-img-top" alt="Teacher Avatar"/>
          <div class="card-body">
            <h6>
              <span class="fw-bolder text-dark">Teacher Name: </span> {{ $user->fullname }}
            </h6>
            <div class="d-flex">
              <div>
                <span class="text-dark fw-bolder">Subjects:</span>
              </div>
              <div class="ms-50">
                @foreach ($user->subjects as $item)
                    <span class="badge badge-pill bg-light-primary border-primary mb-25">
                      {{ $item->subject->name }}
                    </span>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header border-bottom">
            <h4 class="card-title text-primary">
              Teacher's Information
            </h4>
          </div>
          <div class="card-body mt-2">
            <form action="{{ route('teacher.profile.general') }}" method="POST" class="form form-horizontal">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="fname-icon">First Name</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge">
                              <span class="input-group-text"><i data-feather="user"></i></span>
                              <input type="text" id="fname-icon" class="form-control" name="first_name" value="{{ $user->first_name }}" placeholder="First Name" required />
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="mname-icon">Middle Name</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge">
                              <span class="input-group-text"><i data-feather="user"></i></span>
                              <input type="text" id="mname-icon" class="form-control" name="middle_name" value="{{ $user->middle_name }}" placeholder="Middle Name" required />
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="lname-icon">Last Name</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge">
                              <span class="input-group-text"><i data-feather="user"></i></span>
                              <input type="text" id="lname-icon" class="form-control" name="last_name" value="{{ $user->last_name }}" placeholder="Last Name" required />
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="username">Username</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge">
                              <span class="input-group-text"><i data-feather="user"></i></span>
                              <input type="text" id="username" class="form-control" name="username" value="{{ $user->username }}" placeholder="Username" required />
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="pass-icon">Password</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge form-password-toggle">
                              <span class="input-group-text"><i data-feather="lock"></i></span>
                              <input type="password" id="pass-icon" class="form-control" name="password" placeholder="Password" required />
                              <span class="input-group-text cursor-pointer">
                                <i data-feather="eye"></i>
                              </span>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-sm-9 offset-sm-3">
                  <button type="submit" class="btn btn-relief-primary">Submit Changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card">
          <div class="card-header border-bottom">
            <h4 class="card-title text-primary">
              Teacher's Password
            </h4>
          </div>
          <div class="card-body mt-2">
            <form action="{{ route('teacher.profile.password') }}" method="POST" class="form form-horizontal">
              @csrf
              @method('PATCH')
              <div class="row">
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="old-pass-icon">Old Password</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge form-password-toggle">
                              <span class="input-group-text"><i data-feather="lock"></i></span>
                              <input type="password" id="old-pass-icon" class="form-control" name="password_old" placeholder="Old Password" required />
                              <span class="input-group-text cursor-pointer">
                                <i data-feather="eye"></i>
                              </span>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="one-pass-icon">Password</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge form-password-toggle">
                              <span class="input-group-text"><i data-feather="lock"></i></span>
                              <input type="password" id="one-pass-icon" class="form-control" name="password" placeholder="Password" required />
                              <span class="input-group-text cursor-pointer">
                                <i data-feather="eye"></i>
                              </span>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1 row">
                      <div class="col-sm-3">
                          <label class="col-form-label fw-bold d-flex justify-content-end align-items-center" for="two-pass-icon">Confirm Password</label>
                      </div>
                      <div class="col-sm-9">
                          <div class="input-group input-group-merge form-password-toggle">
                              <span class="input-group-text"><i data-feather="lock"></i></span>
                              <input type="password" id="two-pass-icon" class="form-control" name="password_confirmation" placeholder="Confirm Password" required />
                              <span class="input-group-text cursor-pointer">
                                <i data-feather="eye"></i>
                              </span>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-sm-9 offset-sm-3">
                  <button type="submit" class="btn btn-relief-primary">Submit New Password</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection