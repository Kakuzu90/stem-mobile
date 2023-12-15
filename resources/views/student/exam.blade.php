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