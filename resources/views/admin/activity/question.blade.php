@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        Questions for {{ $activity->title }} | STEM
    @endif
@endsection

@section('plugin')
    <link rel="stylesheet" href="{{ asset('app-assets/css/pages/app-file-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('body')
    <question api="{{ route('api.admin.activities.index', $activity->id) }}" image="{{ route('api.admin.image') }}" />
@endsection

@section('scripts')
    <script src="{{ asset('app-assets/js/scripts/pages/app-file-manager.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection