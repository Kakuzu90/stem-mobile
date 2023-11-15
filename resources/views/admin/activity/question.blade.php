@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        Questions for {{ $activity->title }} | STEM
    @endif
@endsection

@section('body')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Questions for {{ $activity->title }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(;)">Informations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Questions for {{ $activity->title }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection