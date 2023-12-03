@extends('layouts.student')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->guard('student')->user()->fullname }} to E-Learning Management System | E-LMS
  @else
    Classroom | E-LMS
  @endif
@endsection

@section('plugin')
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('body')

<classroom 
  api="{{ route('api.student.classroom.index', [$data['classroom'], $data['subject']]) }}"
/>

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
@endsection