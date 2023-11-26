@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->user()->name }} to E-Learning Management System | E-LMS
  @else
    My Class | E-LMS
  @endif
@endsection

@section('plugin')
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('body')
  <my-class 
    api="{{ route('api.teacher.my-class.index') }}" 
    image="{{ asset('images/stemobile-background.jpg') }}" />
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