@extends('layouts.student')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->guard('student')->user()->fullname }} to E-Learning Management System | E-LMS
  @else
    Exam Room | E-LMS
  @endif
@endsection

@section('plugin')
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('body')

  <div class="content-body">
    <div class="col-lg-7 mx-auto">
      <div class="card border mb-1">
        <div class="card-header p-1 align-items-center">
          <h4 class="card-title text-primary mb-0">
            Assignment Exam
          </h4>
          <span class="me-50">
            <span class="fw-bolder text-dark">Time Remaining:</span>
            <span class="fw-bold ms-25 text-primary">00:12:30</span>
          </span>
        </div>
      </div>
      <div class="card border mb-2">
        <div class="card-body p-75">
          <div class="breadcrumb-wrapper">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ms-50">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
            </nav>
          </div>
        </div>
      </div>
      <h4 class="fw-bolder text-dark mb-0">
        Test I.
      </h4>
      <p>Please select the best answer.</p>
      <div class="card border my-1">
        <div class="card-body p-1">
          <h5 class="mb-0">
            <span class="fw-bolder text-dark">1.</span>
            What is the sum of 1 and 2?
          </h5>
          <p class="ms-1 mb-25">Direction here if any here.</p>
          <div class="d-flex justify-content-center align-items-center mb-50">
            <img src="{{ asset('images/placeholder.png') }}" class="cursor-pointer" height="200" alt="Placeholder Image" />
          </div>
          <div class="col-lg-8 col-12 mx-auto">
            <div class="row">
              <div class="col">
                <span class="fw-bolder text-dark">A.</span> Sample A
              </div>
              <div class="col text-end">
                <span class="fw-bolder text-dark">B.</span> Sample B
              </div>
            </div>
            <div class="row">
              <div class="col">
                <span class="fw-bolder text-dark">C.</span> Sample C
              </div>
              <div class="col text-end">
                <span class="fw-bolder text-dark">D.</span> Sample D
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-relief-primary">
          <i data-feather="save"></i> Submit Answer
        </button>
      </div>
    </div>
  </div>
    
@endsection

@section('scripts')
  {{-- <script>
    $.blockUI({
        message: '<div class="spinner-border text-primary" role="status"></div>',
        css: {
            backgroundColor: 'transparent',
            border: '0'
        },
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8
        }
    });
  </script> --}}
  <script src="{{ asset('js/app.js') }}"></script>
@endsection