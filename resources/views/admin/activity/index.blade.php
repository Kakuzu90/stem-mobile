@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        Activities | STEM
    @endif
@endsection

@section('body')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Activities</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(;)">Activities & Notifications</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Activities
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection