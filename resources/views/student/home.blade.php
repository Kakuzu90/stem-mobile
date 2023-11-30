@extends('layouts.student')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->guard('student')->user()->fullname }} to E-Learning Management System | E-LMS
  @else
    My Class | E-LMS
  @endif
@endsection

@section('plugin')
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('body')
  @if ($announcement)
  <div class="col-lg-8 mx-auto">
    <div class="alert alert-danger" role="alert">
      <div class="alert-body">
        <strong>{{ $announcement->announcement->title }}:</strong> {{ $announcement->announcement->context }}
      </div>
    </div>
  </div>
  @endif
  <div class="content-body">
    <student-class 
      api="{{ route('api.student.my-class.year') }}"
      image="{{ asset('images/stemobile-background.jpg') }}"
    />
  </div>
@endsection

@section('scripts')
  <script>
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
  </script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
@endsection