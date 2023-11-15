@extends('layouts.admin')

@section('title')
    @if (Session::get('status'))
        Welcome {{ auth()->user()->name }} to E-Learning Management System | STEM
    @else
        Dashboard | STEM
    @endif
@endsection

@section('body')
<div class="content-body">
    
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
           <x-card.date />
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <x-card.user user="Teachers" :count="$data['teacher']" type="1" />
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <x-card.user user="Students" :count="$data['student']" type="2" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="School Year" :count="$data['year']" icon="calendar" color="bg-light-primary" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Grade Level" :count="$data['grade']" icon="bar-chart" color="bg-light-success" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Sections" :count="$data['section']" icon="briefcase" color="bg-light-warning" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Classrooms" :count="$data['classroom']"  icon="columns" color="bg-light-info" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Subjects" :count="$data['subject']" icon="layers" color="bg-light-danger" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Announcements" :count="$data['announcement']" icon="volume-2" color="bg-light-warning" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Quiz" :count="$data['quiz']" icon="edit" color="bg-light-success" />
        </div>
        <div class="col-lg-3 col-md-4 col-12">
            <x-card.statistic title="Assignments" :count="$data['assignment']" icon="edit" color="bg-light-primary" />
        </div>
    </div>

</div>
@endsection