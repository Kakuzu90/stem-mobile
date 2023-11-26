@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->user()->name }} to E-Learning Management System | E-LMS
  @else
  Results for {{ $activity->title }} | E-LMS
  @endif
@endsection

@section('plugin')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('body')
<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
      <div class="row breadcrumbs-top">
          <div class="col-12">
              <h2 class="content-header-title float-start mb-0">Results for {{ $activity->title }}</h2>
              <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                          <a href="javascript:void(;)">Activities</a>
                      </li>
                      <li class="breadcrumb-item active">
                          Results for {{ $activity->title }}
                      </li>
                  </ol>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="content-body">
  <result
    api="{{ route('api.teacher.result.index', $activity->id) }}"
    result="{{ route('teacher.student.result', ['activity' => $activity->id]) }}"
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
@endsection