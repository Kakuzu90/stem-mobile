@extends('layouts.student')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->guard('student')->user()->fullname }} to E-Learning Management System | E-LMS
  @else
    Classroom | E-LMS
  @endif
@endsection

@section('body')
<div class="content-body">
  <div class="row">
    <div class="col-lg-4">
      <div class="card border-left-active">
        <div class="card-header">
          <h4 class="card-title">Classroom Informations</h4>
        </div>
        <div class="card-body">
          <h6 class="text-dark">
            <span class="fw-bolder text-primary">Teacher Name:</span>
            <span>Clyde C. Arellano</span>
          </h6>
          <h6 class="text-dark">
            <span class="fw-bolder text-primary">Subject:</span>
            <span>MATH</span>
          </h6>
          <h6 class="text-dark">
            <span class="fw-bolder text-primary">Section:</span>
            <span>Jupiter</span>
          </h6>
          <h6 class="text-dark">
            <span class="fw-bolder text-primary">Grade:</span>
            <span>12</span>
          </h6>
          <h6 class="text-dark">
            <span class="fw-bolder text-primary">S.Y:</span>
            <span>2023 - 2024</span>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-md-6 col-6">
          <div class="card cursor-pointer text-center border-bottom-success">
            <div class="card-body">
              <div class="avatar avatar-lg bg-light-success p-50 mb-1">
                <div class="avatar-content">
                    <i data-feather="file-minus" class="font-medium-5"></i>
                </div>
              </div>
              <h2 class="fw-bolder">10</h2>
              <p class="card-text font-small-4 fw-bolder text-dark">Assignments</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-6">
          <div class="card cursor-pointer text-center border-bottom-warning">
            <div class="card-body">
              <div class="avatar avatar-lg bg-light-warning p-50 mb-1">
                <div class="avatar-content">
                    <i data-feather="file-plus" class="font-medium-5"></i>
                </div>
              </div>
              <h2 class="fw-bolder">5</h2>
              <p class="card-text font-medium-1 fw-bolder text-dark">Quiz</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-6">
          <div class="card cursor-pointer text-center border-bottom-danger">
            <div class="card-body">
              <div class="avatar avatar-lg bg-light-danger p-50 mb-1">
                <div class="avatar-content">
                    <i data-feather="file-text" class="font-medium-5"></i>
                </div>
              </div>
              <h2 class="fw-bolder">4</h2>
              <p class="card-text font-medium-1 fw-bolder text-dark">Modules</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-8 mx-auto d-flex justify-content-between align-items-center">
    <h4 class="text-dark fw-bolder">
      List of Assignments
    </h4>
  </div>
  <div class="row justify-content-center align-items-center">
    <div class="col-lg-4">
      <div class="card cursor-pointer border-right-success">
        <div class="card-body p-75">
          <h4 class="card-title text-center text-primary mb-50">
            Example Title
          </h4>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Duration:</span>
            <span>10:00</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Start Time:</span>
            <span>10:00 A.M</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">End Time:</span>
            <span>10:10 A.M</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Deadline:</span>
            <span>December 03, 2023</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Date Submitted:</span>
            <span>December 03, 2023</span>
          </h6>
        </div>
        <div class="card-footer p-75 d-flex justify-content-end align-items-center">
          <span class="badge bg-success">Submitted</span>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card cursor-pointer border-right-danger">
        <div class="card-body p-75">
          <h4 class="card-title text-center text-primary mb-50">
            Example Title
          </h4>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Duration:</span>
            <span>?</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Start Time:</span>
            <span>?</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">End Time:</span>
            <span>?</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Deadline:</span>
            <span>December 03, 2023</span>
          </h6>
          <h6 class="mb-0">
            <span class="text-dark fw-bolder">Date Submitted:</span>
            <span>?</span>
          </h6>
        </div>
        <div class="card-footer p-75 d-flex justify-content-end align-items-center">
          <span class="badge bg-danger">Not Yet</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  
@endsection