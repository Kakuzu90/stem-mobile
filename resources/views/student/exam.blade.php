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

  <exam api="{{ route('api.student.exam.index', [$data['activity'], $data['classroom'], $data['subject']]) }}"
    alias="{{ $data['activity'].$data['classroom'].$data['subject'] }}-{{ auth()->guard('student')->id() }}"
  />

  {{-- <div class="row align-items-center">
    <div class="col-10 rounded-pill border shadow-sm p-50 d-flex justify-content-start align-items-center">
      <div class="avatar bg-primary me-25">
        <div class="avatar-content">
            <i data-feather="image" class="avatar-icon"></i>
        </div>
      </div>
      <div class="d-flex flex-column">
        <span class="fw-bolder text-dark mb-0">Filename: 123.png</span>
        <span class="fw-bolder text-dark">Size: 1 MB</span>
      </div>
    </div>
    <div class="col-2">
      <div class="avatar bg-danger">
        <div class="avatar-content">
            <i data-feather="x" class="avatar-icon"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="row align-items-center mt-50">
    <div class="col-10 rounded-pill border shadow-sm p-50 d-flex justify-content-start align-items-center">
      <div class="avatar bg-primary me-25">
        <div class="avatar-content">
            <i data-feather="image" class="avatar-icon"></i>
        </div>
      </div>
      <div class="d-flex flex-column">
        <span class="fw-bolder text-dark mb-0">Filename: 123.png</span>
        <span class="fw-bolder text-dark">Size: 1 MB</span>
      </div>
    </div>
    <div class="col-2">
      <div class="avatar bg-danger">
        <div class="avatar-content">
            <i data-feather="x" class="avatar-icon"></i>
        </div>
      </div>
    </div>
  </div> --}}
    
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