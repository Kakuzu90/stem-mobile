@extends('layouts.teacher')

@section('title')
  @if (Session::get('status'))
    Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
  @else
    My Class | STEM
  @endif
@endsection

@section('body')
  
@endsection

@section('scripts')
  
@endsection