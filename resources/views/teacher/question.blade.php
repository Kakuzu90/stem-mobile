@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->user()->name }} to E-Learning Management System | E-LMS
  @else
  Questions for {{ $data['title'] }} | E-LMS
  @endif
@endsection

@section('plugin')
<link rel="stylesheet" href="{{ asset('app-assets/css/pages/app-file-manager.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('body')
  <question 
    api="{{ route('api.teacher.activities.index', $data['id']) }}" 
    image="{{ route('api.teacher.image') }}" />
@endsection

@section('scripts')
  <script src="{{ asset('app-assets/js/scripts/pages/app-file-manager.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
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
@endsection